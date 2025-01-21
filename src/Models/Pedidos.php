<?php

namespace Models;
use DateTime;

class Pedidos
{

    private static array $errors = [];

    public function __construct(
        private int|null $id,
        private int $usuario_id,
        private string $provincia,
        private string $localidad,
        private string $direccion,
        private float $coste,
        private string $estado,
        private string $fecha,
        private string $hora,

    ){}

    public static function fromArray(array $data): Pedidos{
        return new Pedidos(
            $data['id'] ?? null,
            $data['usuario_id'] ?? null,
            $data['provincia'] ?? null,
            $data['localidad'] ?? null,
            $data['direccion'] ?? null,
            $data['coste'],
            $data['estado'] ?? null,
            $data['fecha'] ?? null,
            $data['hora'] ?? null,
        );

    }


    public static function validator(){

    }

    /**
     * @return array
     */
    public static function getErrors(): array
    {
        return self::$errors;
    }

    /**
     * @param array $errors
     */
    public static function setErrors(array $errors): void
    {
        self::$errors = $errors;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    /**
     * @param int $usuario_id
     */
    public function setUsuarioId(int $usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    /**
     * @return string
     */
    public function getProvincia(): string
    {
        return $this->provincia;
    }

    /**
     * @param string $provincia
     */
    public function setProvincia(string $provincia): void
    {
        $this->provincia = $provincia;
    }

    /**
     * @return string
     */
    public function getLocalidad(): string
    {
        return $this->localidad;
    }

    /**
     * @param string $localidad
     */
    public function setLocalidad(string $localidad): void
    {
        $this->localidad = $localidad;
    }

    /**
     * @return string
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return float
     */
    public function getCoste(): float
    {
        return $this->coste;
    }

    /**
     * @param float $coste
     */
    public function setCoste(float $coste): void
    {
        $this->coste = $coste;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return DateTime
     */
    public function getFecha(): string
    {
        return $this->fecha;
    }


    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }


    public function getHora(): string
    {
        return $this->hora;
    }


    public function setHora(string $hora): void
    {
        $this->hora = $hora;
    }



}