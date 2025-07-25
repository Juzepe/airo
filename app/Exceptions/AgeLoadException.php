<?php

namespace App\Exceptions;

use Exception;

class AgeLoadException extends Exception
{
    public function __construct(string $message = 'One of the ages is not valid.')
    {
        parent::__construct($message);
    }
}
