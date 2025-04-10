<?php

namespace Hazesoft\Backend\Validations;

use Exception;

class ValidationException extends Exception
{
    public function __construct(string $exception, int $status_code = 400)
    {
        echo "
    <div>
        <p>{$exception}</p>
        <p>Status code: {$status_code}</p>
    </div>
    ";
    }
}
