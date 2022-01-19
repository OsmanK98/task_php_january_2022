<?php

namespace App\Service;

use Symfony\Component\Messenger\Exception\HandlerFailedException;

class HandlerExceptionService
{
    public static function getMessage($e)
    {
        while ($e instanceof HandlerFailedException) {
            $e = $e->getPrevious();
        }
        return $e->getMessage();
    }
}
