<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_first_name' => ['required', 'string', 'max:255'],
            'customer_last_name'  => ['required', 'string', 'max:255'],
            'customer_email'      => ['required', 'email', 'max:255'],
            'payment_method'      => ['required', 'string', 'in:credit_card,paypal,cash,transfer'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.product_name'=> ['required', 'string', 'max:255'],
            'items.*.quantity'    => ['required', 'integer', 'min:1'],
            'items.*.unit_price'  => ['required', 'numeric', 'min:0'],
            'user_id'             => ['nullable', 'exists:users,id'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'customer_email'       => 'correo electrónico',
            'items.*.product_name' => 'nombre del producto',
            'items.*.quantity'     => 'cantidad',
            'items.*.unit_price'   => 'precio unitario',
        ];
    }
}
