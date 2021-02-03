<?php

namespace App\Service;

class GenerateTokenService
{
    public static function generateToken(): string
    {
        return md5(uniqid((string) rand(), true));
    }
}