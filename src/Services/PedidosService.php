<?php

namespace Services;

use Repositories\PedidosRepository;
use Models\Pedidos;
class PedidosService
{

    private PedidosRepository $repository;

    public function __construct(){
        $this->repository = new PedidosRepository();
    }

    public function registrarPedido(Pedidos $pedido):int{
        return $this->repository->registrarPedido($pedido);
    }

    public function registrarLineaPedido(int $pedido_id, int $producto_id, int $unidades):void{
        $this->repository->registrarLineaPedido($pedido_id,$producto_id, $unidades );
    }

    public function actualizarStock(int $producto_id, int $cantidad):void{
        $this->repository->actualizarStock($producto_id, $cantidad);
    }

    public function commit():void{
        $this->repository->commit();
    }

    public function rollback():void{
        $this->repository->rollback();
    }

    public function transaccion():void{
        $this->repository->transaccion();
    }
}