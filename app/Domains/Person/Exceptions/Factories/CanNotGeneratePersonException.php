<?php

namespace App\Domains\Person\Exceptions\Factories;

use Exception;
use Throwable;

class CanNotGeneratePersonException extends Exception {

    public $message;

    public function __construct($message = '', $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
