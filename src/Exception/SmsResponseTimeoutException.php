<?php

namespace GoIP\Exception;

use Throwable;

class SmsResponseTimeoutException extends \RuntimeException
{
    public function __construct(int $line, $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('The SMS sent through the line %u did not get any response', $line), $code, $previous);
    }
}
