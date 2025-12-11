<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Product;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use ApiResponder;

    public function store(StoreProductRequest $request): JsonResponse {
        try{
            $validatedData = $request->validated();

            return $this->success(
                __('Product create successfully!'),
                Product::create($request->validated())
            );
        } catch (\Exception $e){
            $message = 'error.' . strtolower($e->getMessage());
            $this->logException('Exception: store - ProductController ' . $message, $validatedData ?? [], $e);
            return $this->error($message, $validatedData ?? [], $e->getCode());
        }
    }

    public function listAllProducts(): JsonResponse {
        try{
            return $this->success(
                __('List All Products'),
                Product::all()
            );
        } catch (\Exception $e){
            $message = 'error.' . strtolower($e->getMessage());
            $this->logException('Exception: listAllProducts - ProductController ' . $message, [], $e);
            return $this->error($message, null, $e->getCode());
        }
    }

    public function getProductById(int $id): JsonResponse
    {
        try{
            $product = Product::find($id);
            if (!$product) throw new ProductNotFoundException("PRODUCT_NOT_FOUND");

            return $this->success(
                __('Detail Product by Id'),
                $product
            );

        } catch (\Exception $e){
            $message = $e->getMessage() === 'PRODUCT_NOT_FOUND' ? 'error.product_not_found' : 'error.' . strtolower($e->getMessage());
            $this->logException('Exception: getProductById - ProductController ' . $message, [], $e);
            return $this->error($message, null, $e->getCode());
        }
    }

    private function logException(string $message, array $data, \Exception $e): void
    {
        Log::warning($message, array_merge($data, ['exception' => $e->getMessage()]));
    }

}
