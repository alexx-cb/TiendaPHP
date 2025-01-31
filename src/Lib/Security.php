<?php

namespace Lib;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Services\UserService;
use Models\User;

class Security
{

    private UserService $userService;

    public function __construct(){
        $this->userService = new UserService();

    }

    final public static function secretKey(): string{
        return $_ENV['SECRET_KEY'];
    }

    final public static function encryptPass(string $pass): string{
        return password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    final public static function validatePass(string $pass,string $passWhash ): string{
        return password_verify($passWhash, $pass);
    }

    final public static function createToken(string $key, array $data): array {
        $time = time();
        $exp = $time + 3600;
        $token = array(
            "iat" => $time,
            "exp" => $exp,
            "data" => $data
        );

        $encodedToken = JWT::encode($token, $key, 'HS256');

        return [
            'token' => $encodedToken,
            'expiration' => $exp
        ];
    }

    public static function validateToken(string $token): bool
    {
        try {
            // Decodificar el token
            $info = JWT::decode($token, new Key(Security::secretKey(), "HS256"));

            // Extraer información del token
            $id = $info->data->id;
            $exp = $info->exp;
            $email = $info->data->email;

            // Verificar si el token ha expirado
            if (time() > $exp) {
                return false;
            }

            // Obtener el usuario de la base de datos
            $user =  new UserService();
            $usuario = $user->getUserByEmail($email);

            // Verificar si el usuario existe y si el email coincide
            if (!$usuario || $usuario->getEmail() !== $email) {
                return false;
            }

            // Si todo es correcto, confirmar la cuenta del usuario
            $usuario->setConfirmado(true);

            return $user->actualizarRegistro($usuario);
        } catch (Exception $e) {
            // Loguear el error para debugging
            error_log("Error validando token: " . $e->getMessage());
            return false;
        }
    }



}