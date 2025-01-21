<?php

namespace Controllers;
use Models\Producto;
use Services\ProductoService;
use Lib\Pages;
class CarritoController
{

    private ProductoService $productoService;
    private Pages $pages;

    /**
     * Constructor para crear instancias de Pages y ProductoService
     */
    public function __construct(){
        $this->productoService = new ProductoService();
        $this->pages = new Pages();
    }

    /**
     * Método para añadir productos al carrito
     * @return void
     */
    public function addCarrito():void{
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            // Recogemos el id de la vista de Productos
            $productoId = (int)$_POST['id'];
            // Creamos una instancia de Producto al recoger todos los datos
            $productos = $this->productoService->buscarPorId($productoId);

            // si hay productos
            if ($productos) {
                // si no esta iniciada la sesion de carrito la inicializamos
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }
                // si esta iniciada la variable de sesion con el producto que se ha añadido al carrito, se incrementa en 1 la cantidad
                // por cada vez que se le da al boton de añadir al carrito
                if (isset($_SESSION['carrito'][$productoId])) {
                    $_SESSION['carrito'][$productoId]['cantidad']++;
                } else {
                    // si no esta iniciada la variable de sesion de carrito con el producto seleccionado, el objeto producto
                    // se pasa a array y se introducen los datos en la variable de sesion y se inicializa la cantidad a 1
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


    /**
     * Funcion para ver el carrito
     * @return void
     */
    public function showCarrito():void{
        $this->pages->render('Carrito/verCarrito');
    }

    /**
     * Método para sumar productos cuando se esta viendo el carrito
     * @return void
     */
    public function sumarProducto(): void{
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            // se pasa el id del producto cada vez que se pulsa el boton
            $productoId = (int)$_POST['id'];

            // se busca el producto completo por Id
            $producto = $this->productoService->buscarPorId($productoId);

            if ($producto) {
                // Buscamos si hay stock disponible del producto
                $stockDisponible = $producto->getStock();


                if (isset($_SESSION['carrito'][$productoId])) {
                    $cantidadActual = $_SESSION['carrito'][$productoId]['cantidad'];
                    // si la cantidad actual del producto es menor a la del stock te permite añadir mas productos, si no, muestra un error
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

    /**
     * Método para restar productos del carrito de la compra
     * @return void
     */
    public function restarProducto(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $productoId = (int)$_POST['id'];
            // si existe el producto en el carrito, se resta en 1 unidad
            if (isset($_SESSION['carrito'][$productoId])) {
                $_SESSION['carrito'][$productoId]['cantidad']--;
                // si el producto es menor a 0, se elimina el producto del carrito
                if ($_SESSION['carrito'][$productoId]['cantidad'] <= 0) {
                    unset($_SESSION['carrito'][$productoId]);
                }
            }
        }
        $this->pages->render('Carrito/verCarrito');
        exit;
    }
}