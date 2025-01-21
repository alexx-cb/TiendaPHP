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

    /**
     * Constructor que inicializa Pages, ProductoService, ErrorController
     */
    public function __construct()
    {
        $this->pages = new Pages();
        $this->service = new ProductoService;
        $this->errorController = new ErrorController;
    }

    /**
     * Metodo que crea un nuevo producto
     * @return void
     */
    public function newProducto(): void{
        // si no eres admin te lleva a la pagina de error
        if ($_SESSION['rol'] === 'admin') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['data']) && !empty($_POST['data'])) {

                    // Creamos un objeto Producto con los datos del POST
                    $producto = Producto::fromArray($_POST['data']);
                    $errors = $producto->validator();

                    if (empty($errors)) {
                        try {
                            // Creamos el nuevo objeto en la base de datos y mostramos de nuevo todos los productos
                            $this->service->newProducto($producto);
                            $_SESSION['register'] = 'Producto creado con éxito';
                            $productos = $this->service->showProductos();
                            $this->pages->render('Productos/showProductos', ['productos' => $productos]);
                            exit;
                        } catch (Exception $e) {
                            $_SESSION['errors']['general'] = $e->getMessage();
                            $_SESSION['register'] = 'Error al crear un producto';
                            $this->pages->render('Productos/newProducto');
                        }
                    } else {
                        $_SESSION['old_data'] = $_POST['data'];
                        $_SESSION['errors'] = $errors;
                        $_SESSION['register'] = 'Fail';
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

    /**
     * Método que muestra todos los productos
     * @return void
     */
    public function showProductos():void{
        $productos = $this->service->showProductos();
        $this->pages->render('Productos/showProductos', ['productos' => $productos]);

    }

    /**
     * Método que nos lleva al formulario de editar Productos
     * @return void
     */
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

    /**
     * Funcion que nos permite editar un producto
     * @return void
     */
    public function editarProducto(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_SESSION['rol'] !== 'admin') {
                $this->errorController->error404();
                return;
            }
            if (!empty($_POST['data'])) {
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


    /**
     * Método que nos permite eliminar un producto como admin
     * @return void
     */
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