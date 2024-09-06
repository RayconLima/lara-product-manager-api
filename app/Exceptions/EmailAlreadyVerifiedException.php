<?php

namespace App\Exceptions;

use App\Exceptions\Traits\RenderToJson;
use Exception;

class EmailAlreadyVerifiedException extends Exception
{
    use RenderToJson;

    protected $message  = 'Not found';
    protected $code     = 400;
}
