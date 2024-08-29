<?php

namespace App\Exceptions;

use App\Exceptions\Traits\RenderToJson;
use Exception;

class NotDeleteException extends Exception
{
    use RenderToJson;

    protected $message  = 'Category cannot be deleted because it has products';
    protected $code     = 400;
}
