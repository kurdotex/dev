<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Exceptions\UserNotFoundException;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Users",
 * description="Endpoints para la gestión de usuarios"
 * )
 */

/**
 * @OA\Schema(
 * schema="User",
 * type="object",
 * title="User",
 * description="Modelo de Usuario",
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="Juan Perez"),
 * @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
 * @OA\Property(property="phone_number", type="string", example="+5491112345678"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class UserController extends Controller
{
    use ApiResponder;

    /**
     * @OA\Get(
     * path="/users",
     * summary="Listar todos los usuarios",
     * tags={"Users"},
     * description="Retorna un listado de todos los usuarios registrados",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Operación exitosa",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="List All Users"),
     * @OA\Property(
     * property="data",
     * type="array",
     * @OA\Items(ref="#/components/schemas/User")
     * )
     * )
     * ),
     * @OA\Response(response=500, description="Error del servidor")
     * )
     */
    public function listAllUsers(): JsonResponse
    {
        try {
            return $this->success(
                __('List All Users'),
                User::all()
            );
        } catch (\Exception $e) {
            $this->logError($e);
            return $this->error('Error retrieving users', null, 500);
        }
    }

    /**
     * @OA\Put(
     * path="/users/{id}",
     * summary="Actualizar un usuario",
     * tags={"Users"},
     * description="Actualiza la información de un usuario existente",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID del usuario a actualizar",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * description="Datos del usuario para actualizar",
     * @OA\JsonContent(
     * required={"name", "email"},
     * @OA\Property(property="name", type="string", example="Juan Modificado"),
     * @OA\Property(property="email", type="string", format="email", example="juan.nuevo@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="NuevaPassword123", description="Opcional"),
     * @OA\Property(property="phone_number", type="string", example="+5491100000000")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Usuario actualizado correctamente",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="User updated successfully!"),
     * @OA\Property(
     * property="data",
     * type="object",
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="name", type="string", example="Juan Modificado"),
     * @OA\Property(property="email", type="string", example="juan.nuevo@example.com")
     * )
     * )
     * ),
     * @OA\Response(response=404, description="Usuario no encontrado"),
     * @OA\Response(response=422, description="Error de validación"),
     * @OA\Response(response=500, description="Error del servidor")
     * )
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        try {
            $user = User::find($request->route('id'));
            if (!$user) throw new UserNotFoundException("USER_NOT_FOUND");

            $validatedData = $request->validated();

            if ($user->email !== $validatedData['email']) $user->email = $validatedData['email'];
            if ($user->phone_number !== $validatedData['phone_number']) $user->phone_number = $validatedData['phone_number'];

            $user->update([
                'name' => $validatedData['name'],
                'password' => isset($validatedData['password']) ? bcrypt($validatedData['password']) : $user->password,
            ]);

            return $this->success(
                __('User updated successfully!'),
                [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email
                ]
            );
        } catch (\Exception $e) {
            $this->logError($e, $request->all());
            $code = $e->getCode() > 0 ? $e->getCode() : 500;
            return $this->error('Error updating user', null, $code);
        }
    }

    /**
     * @OA\Post(
     * path="/users",
     * summary="Crear un nuevo usuario",
     * tags={"Users"},
     * description="Registra un nuevo usuario en la base de datos",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Datos para crear el usuario",
     * @OA\JsonContent(
     * required={"name", "email", "password", "phone_number"},
     * @OA\Property(property="name", type="string", example="Maria Lopez"),
     * @OA\Property(property="email", type="string", format="email", example="maria@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="Secret123"),
     * @OA\Property(property="phone_number", type="string", example="+5491198765432")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Usuario creado exitosamente",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="User created successfully!"),
     * @OA\Property(property="data", ref="#/components/schemas/User")
     * )
     * ),
     * @OA\Response(response=422, description="Error de validación (Email duplicado, datos faltantes)"),
     * @OA\Response(response=500, description="Error del servidor")
     * )
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'phone_number' => $validatedData['phone_number'],
            ]);

            return $this->success(
                __('User created successfully!'),
                $user
            );
        } catch (\Exception $e) {
            $this->logError($e, $request->all());
            return $this->error('Error creating user', null, 500);
        }
    }
}
