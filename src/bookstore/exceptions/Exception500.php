<?php

namespace bookstore\exceptions;

class Exception500 extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        if (empty($cod)){
            $this->code = 500;
        }
    }
}