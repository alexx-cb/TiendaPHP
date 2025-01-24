<?php

namespace Lib;

use Firebase\JWT\JWT;

class Security
{

    final public static function secrestKey(): string{
        return $_ENV['SECRET_KEY'];
    }

    final public static function encryptPass(string $pass): string{
        return password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    final public static function validatePass(string $pass,string $passWhash ): string{
        return password_verify($passWhash, $pass);
    }

    final public static function createToken(string $key, array $data): string{

        $time = time();
        $token = array(
            "iat" => $time,
            "exp" => $time + 3600,
            "data" => $data
        );

        return JWT::encode($token, $key, 'HS256');
    }

}