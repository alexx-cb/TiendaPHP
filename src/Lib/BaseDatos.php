<?php
namespace Lib;

use PDO;
use PDOException;

class BaseDatos
{
    private PDO $conexion;
    private string $servidor;
    private string $usuario;
    private string $pass;
    private string $base_datos;
    private string $tipo_de_base;

    private mixed $resultado;


    public function __construct()
    {
        $this->tipo_de_base = "mysql";
        $this->servidor = $_ENV["SERVERNAME"];
        $this->usuario = $_ENV["USER"];
        $this->pass = $_ENV["PASSWORD"];
        $this->base_datos = $_ENV["DATABASE"];
        $this->conexion = $this->conectar();
    }

    private function conectar(): PDO | false
    {
        try {
            $opciones = [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];
            return new PDO(
                "{$this->tipo_de_base}:host={$this->servidor};dbname={$this->base_datos}",
                $this->usuario,
                $this->pass,
                $opciones
            );
        } catch (PDOException $e) {
            $_SESSION['errors']=  $e->getMessage();
            return false;
        }
    }


    public function prepare(string $sql){
        return $this->conexion->prepare($sql);
    }

    public function lastInsertId(): string
    {
        try {
            return $this->conexion->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al obtener el último ID insertado: " . $e->getMessage());
            throw new PDOException("No se pudo obtener el último ID insertado.");
        }
    }

    public function transaccion():void{
        $this->conexion->beginTransaction();
    }

    public function commit():void{
        $this->conexion->commit();
    }

    public function rollback():void{
        $this->conexion->rollBack();
    }

}