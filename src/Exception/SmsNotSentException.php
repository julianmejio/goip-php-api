<?php

namespace GoIP\Exception;

use Throwable;

class SmsNotSentException extends \RuntimeException
{
    public function __construct(int $line, string $addressee, ?string $errorDetails = null, $code = 0, Throwable $previous = null)
    {
        $errorMessage = sprintf("The SMS sent to %s though the line %u was not delivered", $addressee, $line);
        if (null !== $errorDetails) {
            $errorMessage .= sprintf('. Details: %s', $errorDetails);
        }
        parent::__construct($errorMessage, $code, $previous);
    }
}
