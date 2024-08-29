<?php

namespace App\Exceptions;

use App\Exceptions\Traits\RenderToJson;
use Exception;

class LoginInvalidException extends Exception
{
    use RenderToJson;

    protected $message  = 'Email and password don\'t match';
    protected $code     = 400;
}
