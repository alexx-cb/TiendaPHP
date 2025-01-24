<?php

namespace Repositories;
use Lib\BaseDatos;
use Models\Categoria;
use PDO;
use PDOException;
class CategoriaRepository
{
    private BaseDatos $db;

    public function __construct(){
        $this->db = new BaseDatos();
    }

    public function newCategoria(string $nombre):bool{
        try{
            $insert = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
            $insert->bindValue(":nombre",$nombre);
            $insert->execute();
            return true;

        }catch (PDOException $e){

            error_log("Error al crear el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($insert)){
                $insert->closeCursor();
            }
        }
    }
}