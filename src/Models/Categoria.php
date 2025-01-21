<?php

namespace Models;

use AllowDynamicProperties;

#[AllowDynamicProperties] class Categoria
{

    protected static array $errors = [];

    public function __construct(
        private int|null $id,
        private string $nombre,
    ){}

    public function validator():array{

        $this->sanitize();

        if (empty($this->nombre)) {
            self::$errors['nombre'] = "El nombre es requerido";
        }
        return self::$errors;
    }

    public function sanitize():void{
        $this->name = filter_var(trim($this->nombre), FILTER_SANITIZE_STRING);
    }

    public static function fromArray(array $data):Categoria{
        return new Categoria(
          $data['id']??null,
          $data['nombre']
        );
    }

    /**
     * GETTERS
     */

    public function getId(): ?int{
        return $this->id;
    }
    public function getNombre(): string{
        return $this->nombre;
    }

    public static function getErrors(): array
    {
        return self::$errors;
    }

    /**
     * SETTERS
     */

    public function setNombre(string $nombre): void{
        $this->nombre = $nombre;
    }

    public static function setErrors(array $errors): void
    {
        self::$errors = $errors;
    }
}