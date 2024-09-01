<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\Traits\RenderToJson;

class InternalServerException extends Exception
{
    use RenderToJson;

    protected $message  = 'Internal Server Error';
    protected $code     = 500;
}
