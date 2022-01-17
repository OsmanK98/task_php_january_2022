<?php

namespace App\Exception;

class AssertException extends \Exception
{
    public static function createMessage(string $message): self
    {
        return new self($message);
    }
}
