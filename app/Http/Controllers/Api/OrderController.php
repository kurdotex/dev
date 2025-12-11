<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Orders",
 * description="Endpoints para la gestión de órdenes de compra"
 * )
 */

/**
 * @OA\Schema(
 * schema="OrderItem",
 * type="object",
 * required={"product_name", "quantity", "unit_price"},
 * @OA\Property(property="product_name", type="string", example="Monitor 24 pulgadas"),
 * @OA\Property(property="quantity", type="integer", example=1),
 * @OA\Property(property="unit_price", type="number", format="float", example=120.50)
 * )
 */

/**
 * @OA\Schema(
 * schema="Order",
 * type="object",
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="user_id", type="integer", example=3),
 * @OA\Property(property="customer_first_name", type="string", example="Carlos"),
 * @OA\Property(property="customer_last_name", type="string", example="Gomez"),
 * @OA\Property(property="customer_email", type="string", example="cliente@email.com"),
 * @OA\Property(property="payment_method", type="string", example="credit_card"),
 * @OA\Property(property="status", type="string", example="pending"),
 * @OA\Property(property="total_amount", type="number", format="float", example=299.99),
 * @OA\Property(
 * property="items",
 * type="array",
 * @OA\Items(ref="#/components/schemas/OrderItem")
 * )
 * )
 */

class OrderController extends Controller
{
    use ApiResponder;

    /**
     * @OA\Get(
     * path="/list/orders",
     * summary="Listar las órdenes del usuario autenticado",
     * tags={"Orders"},
     * description="Retorna solo las órdenes asociadas al token de usuario actual.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Listado de órdenes",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="List orders"),
     * @OA\Property(
     * property="data",
     * type="array",
     * @OA\Items(ref="#/components/schemas/Order")
     * )
     * )
     * ),
     * @OA\Response(response=401, description="No autenticado")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
             return $this->error('Usuario no autenticado', null, 401);
        }

        $orders = Order::with('items')
                       ->where('user_id', $user->id)
                       ->get();

        return $this->success(
            __('List orders'),
            $orders,
        );
    }

    /**
     * @OA\Post(
     * path="/list/orders",
     * summary="Crear una nueva orden",
     * tags={"Orders"},
     * description="Crea una orden con sus ítems calculando el total automáticamente",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"customer_first_name", "customer_last_name", "customer_email", "payment_method", "items"},
     * @OA\Property(property="customer_first_name", type="string", example="Carlos"),
     * @OA\Property(property="customer_last_name", type="string", example="Gomez"),
     * @OA\Property(property="customer_email", type="string", format="email", example="cliente@email.com"),
     * @OA\Property(property="payment_method", type="string", example="credit_card"),
     * @OA\Property(property="user_id", type="integer", example=1),
     * @OA\Property(
     * property="items",
     * type="array",
     * @OA\Items(ref="#/components/schemas/OrderItem")
     * )
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Orden creada exitosamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Store Order"),
     * @OA\Property(property="data", ref="#/components/schemas/Order")
     * )
     * ),
     * @OA\Response(response=422, description="Error de validación"),
     * @OA\Response(response=500, description="Error interno del servidor"),
     * @OA\Response(response=401, description="No autenticado")
     * )
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $calculatedTotal = collect($request->items)->sum(fn($item) =>
            $item['quantity'] * $item['unit_price']
        );

        try {
            return DB::transaction(function () use ($request, $calculatedTotal) {
                $order = Order::create([
                    'user_id'             => $request->user()->id ?? $request->user_id,
                    'customer_first_name' => $request->customer_first_name,
                    'customer_last_name'  => $request->customer_last_name,
                    'customer_email'      => $request->customer_email,
                    'payment_method'      => $request->payment_method,
                    'status'              => 'pending',
                    'total_amount'        => $calculatedTotal,
                ]);

                $order->items()->createMany($request->items);

                return $this->success(
                    'Store Order',
                    $order->load('items'),
                    201
                );
            });

        } catch (\Exception $e) {
            $this->logError($e, $request->all());
            return $this->error(
                'Error interno al procesar la orden',
                null,
                500
            );
        }
    }


    /**
     * @OA\Get(
     * path="/list/orders/{id}",
     * summary="Obtener una orden específica",
     * tags={"Orders"},
     * description="Busca una orden por ID y retorna sus detalles e ítems",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID de la orden",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Orden encontrada",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Order Id: 1"),
     * @OA\Property(property="data", ref="#/components/schemas/Order")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Orden no encontrada"
     * ),
     * @OA\Response(response=401, description="No autenticado")
     * )
     */
    public function getOrderById($id): JsonResponse
    {
        try {
            $order = Order::with('items')->findOrFail($id);
            return $this->success(
                'Order Id: ' . $id,
                $order
            );
        } catch (\Exception $e) {
            return $this->error('Orden no encontrada', null, 404);
        }
    }
}
