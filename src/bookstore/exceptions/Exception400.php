<?php

namespace bookstore\exceptions;

use Throwable;

class Exception400 extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        if (empty($code)){
            $this->code = 400;
        }
    }
}