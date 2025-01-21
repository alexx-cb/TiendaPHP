<?php

namespace Controllers;
use Lib\Pages;
use Models\Producto;
use Services\ProductoService;
use Exception;
use Controllers\ErrorController;
class ProductoController
{

    private Pages $pages;
    private ProductoService $service;
    private ErrorController $errorController;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->service = new ProductoService;
        $this->errorController = new ErrorController;
    }

    public function newProducto(): void {
        if ($_SESSION['rol'] === 'admin') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['data']) && !empty($_POST['data'])) {

                    $producto = Producto::fromArray($_POST['data']);
                    if (empty($producto->validator())) {
                        try {

                            $this->service->newProducto($producto);
                            $this->pages->render('Layout/header');
                        } catch (Exception $e) {
                            $_SESSION['errors'] = $e->getMessage();
                            $_SESSION['register'] = 'Error al crear un producto';
                        }
                    } else {
                        $_SESSION['register'] = 'Fail';
                        $_SESSION['errors'] = Producto::getErrors();
                        $this->pages->render('Productos/newProducto');
                    }
                } else {
                    $_SESSION['register'] = 'Fail';
                    $this->pages->render('Productos/newProducto');
                }
            } else {
                $this->pages->render('Productos/newProducto');
            }
        } else {
            $this->errorController->error404();
        }
    }

    public function showProductos():void{
        $productos = $this->service->showProductos();
        $this->pages->render('Productos/showProductos', ['productos' => $productos]);

    }

    public function renderizarEditarProducto():void{
        if($_SESSION['rol'] === 'admin'){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $producto = $this->service->buscarPorId($_POST['id']);
                $this->pages->render('Productos/editarProducto', ['producto' => $producto]);
            }
        }else{
            $this->errorController->error404();
        }

    }

    public function editarProducto(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_SESSION['rol'] !== 'admin') {
                $this->errorController->error404();
                return;
            }
            if (isset($_POST['data']) && !empty($_POST['data'])) {
                $productoData = $_POST['data'];
                $producto = Producto::fromArray($productoData);

                if (empty($producto->validator())) {
                    try {

                        $this->service->editarProducto($producto);

                        $_SESSION['success'] = "Producto actualizado correctamente.";

                        $productos = $this->service->showProductos();
                        $this->pages->render('Productos/showProductos', ['productos' => $productos]);
                    } catch (Exception $e) {

                        $_SESSION['errors'] = $e->getMessage();
                        $_SESSION['register'] = 'Error al actualizar el producto.';
                        $this->pages->render('Productos/editarProducto', ['producto' => $producto]);
                    }
                } else {

                    $_SESSION['errors'] = Producto::getErrors();
                    $_SESSION['register'] = 'Fallo en la validación.';
                    $this->pages->render('Productos/editarProducto', ['producto' => $producto]);
                }
            } else {
                $_SESSION['register'] = 'Fallo al recibir los datos.';
                $productos = $this->service->showProductos();
                $this->pages->render('Productos/showProductos', ['productos' => $productos]);
            }
        } else {
            $_SESSION['errors'] = 'Método no permitido.';
            $productos = $this->service->showProductos();
            $this->pages->render('Productos/showProductos', ['productos' => $productos]);
        }
    }

    public function eliminarProducto(): void
    {
        if ($_SESSION['rol'] === 'admin') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['id'])) {
                    try {
                        $this->service->eliminarProducto((int)$_POST['id']);

                        $_SESSION['success'] = "Producto eliminado correctamente.";
                        $productos = $this->service->showProductos();
                        $this->pages->render('Productos/showProductos', ['productos' => $productos]);
                    } catch (Exception $e) {
                        $_SESSION['errors'] = $e->getMessage();
                        $this->pages->render('Productos/showProductos', ['errors' => $_SESSION['errors']]);
                    }
                } else {
                    $_SESSION['errors'] = 'No se proporcionó un ID de producto.';
                    $this->pages->render('Productos/showProductos', ['errors' => $_SESSION['errors']]);
                }
            } else {
                $_SESSION['errors'] = 'Método no permitido.';
                $this->pages->render('Productos/showProductos', ['errors' => $_SESSION['errors']]);
            }

        } else {
            $this->errorController->error404();
        }
    }
}