<?php

namespace App\Exceptions;

use App\Traits\ApiResponder;
use Exception;

class ProductNotFoundException extends Exception
{
    use ApiResponder;

    public function __construct($message = "Product not found", $code = 404)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        return $this->error(
            __('Product not found'),
            [
                'message' => $this->getMessage()
            ],
            $this->getCode()

        );
    }
}
