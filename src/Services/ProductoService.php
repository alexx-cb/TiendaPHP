<?php

namespace Services;

use Models\Producto;
use Repositories\ProductoRepository;

class ProductoService
{

    private ProductoRepository $repository;

    public function __construct(){
        $this->repository = new ProductoRepository();
    }

    public function newProducto(Producto $producto):void{
        $this->repository->newProducto($producto);
    }

    public function showProductos():array|bool{
        return $this->repository->showProductos();
    }

    public function buscarPorId(int $id):Producto|bool{
        return $this->repository->buscarPorId($id);
    }

    public function editarProducto(Producto $producto):void{
        $this->repository->editarProducto($producto);
    }

    public function eliminarProducto(int $id):void{
        $this->repository->eliminarProducto($id);
    }

}