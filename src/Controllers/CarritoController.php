<?php

namespace Controllers;
use Models\Producto;
use Services\ProductoService;
use Lib\Pages;
class CarritoController
{

    private ProductoService $productoService;
    private Pages $pages;

    public function __construct(){
        $this->productoService = new ProductoService();
        $this->pages = new Pages();
    }

    public function addCarrito():void{
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $productoId = (int)$_POST['id'];
            $productos = $this->productoService->buscarPorId($productoId);

            if ($productos) {
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }
                if (isset($_SESSION['carrito'][$productoId])) {
                    $_SESSION['carrito'][$productoId]['cantidad']++;
                } else {
                    $_SESSION['carrito'][$productoId] = $productos->toArray();
                    $_SESSION['carrito'][$productoId]['cantidad'] = 1;
                }
                $_SESSION['mensaje'] = 'Producto añadido al carrito';

            } else {
                $_SESSION['mensaje'] = 'Producto no encontrado';

            }
        }
        $listaProductos = $this->productoService->showProductos();
        $this->pages->render('Productos/showProductos', ['productos' => $listaProductos]);
    }


    public function showCarrito():void{
        $this->pages->render('Carrito/verCarrito');
    }

    public function sumarProducto(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $productoId = (int)$_POST['id'];

            $producto = $this->productoService->buscarPorId($productoId);

            if ($producto) {
                $stockDisponible = $producto->getStock();

                if (isset($_SESSION['carrito'][$productoId])) {
                    $cantidadActual = $_SESSION['carrito'][$productoId]['cantidad'];
                    if ($cantidadActual < $stockDisponible) {
                        $_SESSION['carrito'][$productoId]['cantidad']++;
                    } else {
                        $_SESSION['error_stock'] = 'No hay suficiente stock para aumentar la cantidad de este producto.';
                    }
                }
            }

            $this->pages->render('Carrito/verCarrito');
            exit;
        }
    }

    public function restarProducto(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $productoId = (int)$_POST['id'];
            if (isset($_SESSION['carrito'][$productoId])) {
                $_SESSION['carrito'][$productoId]['cantidad']--;
                if ($_SESSION['carrito'][$productoId]['cantidad'] <= 0) {
                    unset($_SESSION['carrito'][$productoId]);
                }
            }
        }
        $this->pages->render('Carrito/verCarrito');
        exit;
    }
}