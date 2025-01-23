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

    /**
     * Store a new product.
     *
     * Creates a new product with the provided data.
     *
     * @group Product Management
     * @bodyParam name string required The name of the product. Example: "Sample Product"
     * @bodyParam description string required A brief description of the product. Example: "This is a sample product."
     * @bodyParam price number required The price of the product. Example: 99.99
     * @bodyParam stock number required The stock of the product. Example: 100
     * @response 201 {
     *   "status": "success",
     *   "message": "Product create successfully!",
     *   "data": {
     *     "id": 1,
     *     "name": "Sample Product",
     *     "description": "This is a sample product.",
     *     "price": 99.99,
     *     "stock": 100,
     *     "created_at": "2024-10-08T12:34:56.000000Z",
     *     "updated_at": "2024-10-08T12:34:56.000000Z"
     *   }
     * }
     * @response 422 {
     *   "status": "error",
     *   "message": "Validation error.",
     *   "errors": {
     *     "name": ["The name field is required."]
     *   }
     * }
     */
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
    /**
     * List all products.
     *
     * Retrieves a list of all available products.
     *
     * @group Product Management
     * @response 200 {
     *   "status": "success",
     *   "message": "List All Products",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Sample Product",
     *       "description": "This is a sample product.",
     *       "price": 99.99,
     *       "stock": 100,
     *       "created_at": "2024-10-08T12:34:56.000000Z",
     *       "updated_at": "2024-10-08T12:34:56.000000Z"
     *     }
     *   ]
     * }
     */
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
    /**
     * Get product by ID.
     *
     * Retrieve a specific product by its ID.
     *
     * @group Product Management
     * @urlParam id integer required The ID of the product. Example: 1
     * @response 200 {
     *   "status": "success",
     *   "message": "Detail Product by Id",
     *   "data": {
     *     "id": 1,
     *     "name": "Sample Product",
     *     "description": "This is a sample product.",
     *     "price": 99.99,
     *     "stock": 100,
     *     "created_at": "2024-10-08T12:34:56.000000Z",
     *     "updated_at": "2024-10-08T12:34:56.000000Z"
     *   }
     * }
     * @response 404 {
     *   "status": "error",
     *   "message": "error.product_not_found",
     *   "data": null
     * }
     */
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

    /**
     * Log exceptions in the log file.
     *
     * @param string $message The exception message.
     * @param array $data Additional data related to the error.
     * @param \Exception $e The caught exception instance.
     * @return void
     */
    private function logException(string $message, array $data, \Exception $e): void
    {
        Log::warning($message, array_merge($data, ['exception' => $e->getMessage()]));
    }

}
