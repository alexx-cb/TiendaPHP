<?php

namespace Repositories;

use Lib\BaseDatos;
use Models\Pedidos;
use PDOException;
use PDO;

class PedidosRepository
{

    private BaseDatos $db;

    private PDO $pdo;

    public function __construct(){
        $this->db = new BaseDatos();
    }

    public function registrarPedido(Pedidos $pedido):int|bool {
        try {
            $sentencia = $this->db->prepare("INSERT INTO pedidos 
                                         (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) 
                                         VALUES (:usuario_id, :provincia, :localidad, :direccion, :coste, :estado, :fecha, :hora)");
            $sentencia->bindValue(':usuario_id', $pedido->getUsuarioId());
            $sentencia->bindValue(':provincia', $pedido->getProvincia());
            $sentencia->bindValue(':localidad', $pedido->getLocalidad());
            $sentencia->bindValue(':direccion', $pedido->getDireccion());
            $sentencia->bindValue(':coste', $pedido->getCoste());
            $sentencia->bindValue(':estado', $pedido->getEstado());
            $sentencia->bindValue(':fecha', $pedido->getFecha());
            $sentencia->bindValue(':hora', $pedido->getHora());

            $sentencia->execute();

            return (int)$this->db->lastInsertId();

        }catch(PDOException $e){
            error_log("Error al crear el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($sentencia)){
                $sentencia->closeCursor();
            }
        }
    }

    public function registrarLineaPedido($pedido_id, $producto_id, $unidades):bool{
        try {
            $sentencia = $this->db->prepare("INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) 
                                         VALUES (:pedido_id, :producto_id, :unidades)");
            $sentencia->bindValue(':pedido_id', $pedido_id);
            $sentencia->bindValue(':producto_id', $producto_id);
            $sentencia->bindValue(':unidades', $unidades);

            $sentencia->execute();
            return true;

        }catch(PDOException $e){
            error_log("Error al crear el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($sentencia)){
                $sentencia->closeCursor();
            }
        }
    }

    public function actualizarStock($producto_id, $cantidad):bool{
        try {
            $sentencia = $this->db->prepare("UPDATE productos SET stock = stock - :cantidad WHERE id = :productoId");
            $sentencia->bindValue(':cantidad', $cantidad, PDO::PARAM_INT);
            $sentencia->bindValue(':productoId', $producto_id, PDO::PARAM_INT);

            $sentencia->execute();
            return true;

        } catch (PDOException $e) {
            error_log("Error al actualizar el stock: " . $e->getMessage());
            return false;
        } finally {
            if (isset($sentencia)) {
                $sentencia->closeCursor();
            }
        }
    }

    public function commit():void{
        $this->db->commit();
    }

    public function rollback():void{
        $this->db->rollback();
    }

    public function transaccion():void{
        $this->db->transaccion();
    }

}