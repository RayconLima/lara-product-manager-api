<?php

namespace App\Exceptions;

use App\Exceptions\Traits\RenderToJson;
use Exception;

class TokenInvalidException extends Exception
{
    use RenderToJson;

    protected $message  = 'Not found';
    protected $code     = 400;
}
