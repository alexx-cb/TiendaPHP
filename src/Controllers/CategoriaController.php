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

    public function __construct(){
        $this->pages = new Pages();
        $this->service = new CategoriaService();
        $this->productoService = new ProductoService();
        $this->errorController = new ErrorController();
    }

    public function newCategoria(): void
    {
        if ($_SESSION['rol'] === 'admin') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['data']) && !empty($_POST['data']['nombre'])) {
                    $categoria = Categoria::fromArray($_POST['data']);

                    if ($categoria->validator()) {
                        try {
                            $this->service->newCategoria($categoria->getNombre());
                            $productos = $this->productoService->showProductos();
                            $this->pages->render('Productos/showProductos', ['productos' => $productos]);
                        } catch (Exception $e) {
                            $_SESSION['errors'] = $e->getMessage();
                            $_SESSION['register'] = 'fail';
                        }
                    } else {
                        $_SESSION['errors'] = Categoria::getErrors();
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