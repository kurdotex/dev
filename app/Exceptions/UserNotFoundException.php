<?php

namespace App\Exceptions;

use App\Traits\ApiResponder;
use Exception;

class UserNotFoundException extends Exception
{
    use ApiResponder;

    public function __construct($message = "User not found", $code = 404)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        return $this->error(
            __('User not found'),
            [
                'message' => $this->getMessage()
            ],
            $this->getCode()

        );
    }
}
