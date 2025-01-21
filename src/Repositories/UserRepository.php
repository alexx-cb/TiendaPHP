<?php

namespace Repositories;

use Lib\BaseDatos;
use Models\User;
use PDO;
use PDOException;

class UserRepository
{

    private BaseDatos $db;
    public function __construct(){
        $this->db = new BaseDatos();
    }

    public function registerUser(User $user):bool{
        try{
            $insert = $this->db->prepare("INSERT INTO usuarios (nombre, apellidos, email, password, rol) 
            VALUES(:nombre, :apellido, :email, :password, :rol)");

            $insert->bindValue(":nombre", $user->getNombre(), PDO::PARAM_STR);
            $insert->bindValue(":apellido", $user->getApellido(), PDO::PARAM_STR);
            $insert->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            $insert->bindValue(":password", $user->getPass(), PDO::PARAM_STR);
            $insert->bindValue(":rol", $user->getRol(), PDO::PARAM_STR);

            $insert->execute();
            return true;
        }catch(PDOException $e){
            error_log("Error al crear el usuario: ".$e->getMessage());
            return false;
        }finally{
            if(isset($insert)){
                $insert->closeCursor();
            }
        }
    }

    public function getUserByEmail(string $email): ?User
    {
        try {
            $consulta = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
            $consulta->bindValue(":email", $email, PDO::PARAM_STR);
            $consulta->execute();

            $datos = $consulta->fetch(PDO::FETCH_ASSOC);

            if (!$datos) {
                return null;
            }
            return User::fromArray($datos);

        } catch (PDOException $e) {
            error_log("Error al obtener el usuario: " . $e->getMessage());
            return null;
        } finally {
            if (isset($consulta)) {
                $consulta->closeCursor();
            }
        }
    }

    public function getUserById(int $id):User|bool {
        try{
            $consulta = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
            $datos = $consulta->fetch(PDO::FETCH_ASSOC);
            return User::fromArray($datos);

        }catch(PDOException $e){
            error_log("Error al obtener el usuario: ".$e->getMessage());
            return false;
        }finally{
            if(isset($consulta)){
                $consulta->closeCursor();
            }
        }
    }


}