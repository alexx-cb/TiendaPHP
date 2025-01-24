<?php

namespace Controllers;
use Exception;
use Lib\Pages;
use Services\CategoriaService;
use Models\Categoria;
use Services\ProductoService;
use Controllers\ErrorController;

class CategoriaController
{

    private ErrorController $errorController;
    private Pages $pages;
    private CategoriaService $service;
    private ProductoService $productoService;

    /**
     * Constuctor para instanciar Pages, CategoriaServices, ProductoService y ErrorController
     */
    public function __construct(){
        $this->pages = new Pages();
        $this->service = new CategoriaService();
        $this->productoService = new ProductoService();
        $this->errorController = new ErrorController();
    }

    /**
     * Método para crear nuevas categorias
     * @return void
     */
    public function newCategoria(): void{
        // Si no es admin muestra la pantalla de error
        if ($_SESSION['rol'] === 'admin') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['data']) && !empty($_POST['data']['nombre'])) {
                    $categoria = Categoria::fromArray($_POST['data']);

                    if (!$categoria->validator()) {
                        $_SESSION['errors'] = Categoria::getErrors();
                        $_SESSION['register'] = 'fail';
                        $this->pages->render('Categorias/newCategoria');
                        return; // Detén la ejecución aquí
                    }
                        try {
                            // Creamos la categoria y mostramos de nuevo los productos
                            $this->service->newCategoria($categoria->getNombre());
                            $productos = $this->productoService->showProductos();
                            $this->pages->render('Productos/showProductos', ['productos' => $productos]);
                        } catch (Exception $e) {
                            $_SESSION['errors'] = $e->getMessage();
                            $_SESSION['register'] = 'fail';
                        }

                } else {
                    $_SESSION['errors'] = ['nombre' => 'El nombre es requerido.'];
                    $_SESSION['register'] = 'fail';
                }
            }
            $this->pages->render('Categorias/newCategoria');

        } else {
            $this->errorController->error404();
        }
    }
}