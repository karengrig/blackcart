<?php

namespace App\Exceptions;

use Exception;

class UnknownStoreDriverException extends Exception
{
    public function __construct(string $driverName = "")
    {
        $message = "Unknown store driver '{$driverName}'";

        parent::__construct($message);
    }
}
