<?php

namespace Repositories;

use Lib\BaseDatos;
use Models\Producto;
use PDO;
use PDOException;

class ProductoRepository
{

    private BaseDatos $db;

    public function __construct(){
        $this->db = new BaseDatos();
    }

    public function newProducto(Producto $producto):bool{
        try{
            $insert = $this->db->prepare("INSERT INTO productos 
                                            (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) 
                                            VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)");
            $insert->bindValue(':categoria_id', $producto->getIdCategoria());
            $insert->bindValue(":nombre", $producto->getNombre());
            $insert->bindValue(":descripcion", $producto->getDescripcion());
            $insert->bindValue(":precio", $producto->getPrecio());
            $insert->bindValue(":stock", $producto->getStock());
            $insert->bindValue(":oferta", $producto->getOferta());
            $insert->bindValue(":fecha", $producto->getFecha());
            $insert->bindValue(":imagen", $producto->getImagen());
            $insert->execute();

            return true;
        }catch(PDOException $e){
            error_log("Error al crear el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($insert)){
                $insert->closeCursor();
            }
            unset($insert);
        }
    }

    public function showProductos():array|bool{
        try{
            $consulta = $this->db->prepare("SELECT id, categoria_id, nombre, descripcion, precio, stock, imagen FROM productos");
            $consulta->execute();

            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            if ($datos) {
                $productos = [];
                foreach ($datos as $fila) {
                    $productos[] = Producto::fromArray($fila);
                }
                return $productos;
            }

            return false;
        }catch(PDOException $e){
            error_log("Error al consultar el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($consulta)){
                $consulta->closeCursor();
            }
            unset($consulta);
        }
    }

    public function buscarPorId(int $id):Producto|bool{
        try {
            $consulta = $this->db->prepare('SELECT * FROM productos WHERE id = :id');
            $consulta->bindValue(':id', $id, \PDO::PARAM_INT);
            $consulta->execute();

            $data = $consulta->fetch(\PDO::FETCH_ASSOC);

            if ($data) {
                return Producto::fromArray($data);
            }

            return false;
        }catch(PDOException $e){
            error_log("Error al consultar el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($consulta)){
                $consulta->closeCursor();
            }
            unset($consulta);
        }
    }

    public function editarProducto(Producto $producto):bool{
        try{
            $update = $this->db->prepare('UPDATE productos SET 
            nombre=:nombre, descripcion=:descripcion, precio=:precio, stock=:stock, 
            oferta=:oferta, imagen=:imagen, fecha=:fecha WHERE id = :id');

            $update->bindValue(':nombre', $producto->getNombre());
            $update->bindValue(':descripcion', $producto->getDescripcion());
            $update->bindValue(':precio', $producto->getPrecio());
            $update->bindValue(':stock', $producto->getStock());
            $update->bindValue(':oferta', $producto->getOferta());
            $update->bindValue(':fecha', $producto->getFecha());
            $update->bindValue(':imagen', $producto->getImagen());
            $update->bindValue(':id', $producto->getId());

            $update->execute();
            return true;

        }catch(PDOException $e){
            error_log("Error al consultar el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($update)){
                $update->closeCursor();
            }
            unset($update);
        }
    }

    public function eliminarProducto(int $id):bool{
        try{

            $delete = $this->db->prepare("DELETE FROM productos WHERE id = :id");
            $delete->bindValue(':id', $id, \PDO::PARAM_INT);

            $delete->execute();
            return true;

        }catch(PDOException $e){
            error_log("Error al consultar el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($delete)){
                $delete->closeCursor();
            }
            unset($delete);
        }
    }
}