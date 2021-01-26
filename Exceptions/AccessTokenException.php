<?php

namespace Cobranca\Asaas\Exceptions;

use Exception;

class AccessTokenException extends Exception
{
    public static function invalidToken()
    {
        return new static('O Token fornecido não é válido.');
    }
}