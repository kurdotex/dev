<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="OrderItem",
 *     type="object",
 *     title="Order Item",
 *     description="Item dentro de una orden"
 * )
 */
class OrderItem
{
    /**
     * @OA\Property(
     *     title="Product ID",
     *     example=12
     * )
     * @var integer
     */
    public $product_id;

    /**
     * @OA\Property(
     *     title="Quantity",
     *     example=3
     * )
     * @var integer
     */
    public $quantity;

    /**
     * @OA\Property(
     *     title="Unit price",
     *     example=99.99
     * )
     * @var number
     */
    public $unit_price;

    /**
     * @OA\Property(
     *     title="Subtotal",
     *     example=299.97
     * )
     * @var number
     */
    public $subtotal;
}
