<?php

namespace Models;
class User
{

    protected static array $errors = [];

    public function __construct(
        private int | null $id,
        private string $name,
        private string $surname,
        private string $email,
        private string $pass,
        private string $rol,
        private bool $confirmado,
        private string $token,
        private string $exp_token
    ){
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'pass' => $this->pass,
            'rol' => $this->rol,
            'confirmado' => $this->confirmado,
            'token' => $this->token,
            'exp_token' => $this->exp_token,
        ];
    }

    public static function fromArray(array $data): User{
        return new User(
            $data['id'] ?? null,
            $data['nombre'] ?? '',
            $data['apellido'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? '',
            $data['rol'] ?? 'usuario',
            $data['confirmado'] ?? false,
            $data['token'] ?? '',
            $data['exp_token'] ?? ''
        );
    }

    public function validator(): bool
    {
        self::$errors = [];

        $this->sanitize();

        if(empty($this->name)){
            self::$errors['nombre'] = "El nombre es requerido";
        }
        if(empty($this->surname)){
            self::$errors['apellido'] = "El apellido es requerido";
        }
        if(empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$errors['email'] = "El email es inválido o está vacío";
        }
        if(empty($this->pass)){
            self::$errors['password'] = "La contraseña es requerida";
        }

        return empty(self::$errors);
    }

    public function sanitize(): void
    {
        $this->name = filter_var(trim($this->name), FILTER_SANITIZE_STRING);
        $this->surname = filter_var(trim($this->surname), FILTER_SANITIZE_STRING);
        $this->email = filter_var(trim($this->email), FILTER_SANITIZE_EMAIL);
        $this->pass = filter_var(trim($this->pass), FILTER_SANITIZE_STRING);
    }

    /**
     * @return bool
     */
    public function isConfirmado(): bool
    {
        return $this->confirmado;
    }

    /**
     * @param bool $confirmado
     */
    public function setConfirmado(bool $confirmado): void
    {
        $this->confirmado = $confirmado;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getExpToken(): string
    {
        return $this->exp_token;
    }

    /**
     * @param string $exp_token
     */
    public function setExpToken(string $exp_token): void
    {
        $this->exp_token = $exp_token;
    }



    public function getId(): int{
        return $this->id;
    }
    public function getNombre(): string{
        return $this->name;
    }

    public function getApellido(): string{
        return $this->surname;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getPass(): string{
        return $this->pass;
    }

    public function getRol(): string{
        return $this->rol;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    /**
     * @param string $rol
     */
    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    public static function getErrores(): array{
        return self::$errors;
    }

    public static function setErrores(array $errors): void{
        self::$errors = $errors;
    }
}