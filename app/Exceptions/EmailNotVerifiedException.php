<?php

namespace App\Exceptions;

use Exception;

class EmailNotVerifiedException extends Exception
{
    public function __construct($message = "Please verify your Email...."){
        parent::__construct($message);
    }
}
