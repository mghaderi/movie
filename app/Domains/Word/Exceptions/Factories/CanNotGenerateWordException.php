<?php

namespace App\Domains\Word\Exceptions\Factories;

use Exception;
use Throwable;

class CanNotGenerateWordException extends Exception {
    /**
     * @var
     */
    public $message;

    /**
     * GeneralException constructor.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  Throwable|null  $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
