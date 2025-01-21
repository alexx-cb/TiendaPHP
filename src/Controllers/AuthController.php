<?php

namespace Controllers;

use Lib\Pages;
use Models\User;
use Services\UserService;
use Services\ProductoService;
use Exception;


class AuthController
{
    private Pages $pages;
    private UserService $service;
    private ProductoService $productoService;

    /**
     * Constructor para crear instancias de Pages UserService y ProductoService
     */
    public function __construct()
    {
        $this->pages = new Pages();
        $this->service = new UserService();
        $this->productoService = new ProductoService();
    }

    /**
     * Metodo para registrar un nuevo usuario
     * @return void
     */
    public function register(): void{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['data']) {
                // Guardamos los datos en un objeto tipo User
                $user = User::fromArray($_POST['data']);
                if ($user->validator()) {
                    // Encriptamos contraseña
                    $pass = password_hash($user->getPass(), PASSWORD_BCRYPT, ['cost' => 5]);
                    $user->setPass($pass);

                    // registramos el usuario o mostramos errores
                    try {
                        $this->service->registerUser($user);
                    } catch (Exception $e) {
                        $_SESSION['register'] = 'Fail to create user';
                        $_SESSION['errors'] = $e->getMessage();
                        $this->pages->render('user/form');
                        return;
                    }

                    // Le damos valores al rol del usuario --> Admin / User
                    if ($user->getRol() === 'admin') {
                        $_SESSION['rol'] = 'admin';
                    } else {
                        $_SESSION['rol'] = 'user';
                    }

                    // Renderizamos el formulario para iniciar sesion
                    $this->pages->render('user/login');
                } else {
                    $_SESSION['register'] = 'Fail';
                    $_SESSION['errors'] = User::getErrores();
                    $this->pages->render('user/form', ['userData' => $_POST['data']]);
                }
            } else {
                $_SESSION['register'] = 'fail';
                $this->pages->render('user/form');
            }
        } else {
            $this->pages->render('user/form');
        }
    }

    /**
     * Método para iniciar sesion con un usuario ya registrado
     * @return void
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['data']) {
                // Sanitizamos los datos entrantes
                $email = filter_var(trim($_POST['data']['email']), FILTER_SANITIZE_EMAIL);
                $pass = trim($_POST['data']['pass']);

                // Validar el email y la contraseña
                if (empty($email) || empty($pass)) {
                    $_SESSION['register'] = 'fail';
                    $_SESSION['errors'] = 'Por favor, ingrese su correo y contraseña.';
                    $this->pages->render('user/login', ['userData' => $_POST['data']]);
                    return;
                }

                // Buscamos al usuario por email y creamos un objeto Usuario
                try {
                    $usuario = $this->service->getUserByEmail($email);
                    if (!$usuario) {
                        $_SESSION['register'] = 'fail';
                        $_SESSION['errors'] = 'El correo electrónico no está registrado.';
                        $this->pages->render('user/login', ['userData' => $_POST['data']]);
                        return;
                    }

                    // Verificamos la contraseña
                    if (password_verify($pass, $usuario->getPass())) {

                        // Damos valores a las variables de sesion con los valores del usuario
                        $_SESSION['user'] = $usuario->getNombre();
                        $_SESSION['user_id'] = $usuario->getId();

                        // damos valor a las variables de sesion para el rol
                        if ($usuario->getRol() === 'admin') {
                            $_SESSION['rol'] = 'admin';
                        } else {
                            $_SESSION['rol'] = 'user';
                        }
                        // renderizamos la vista de productos
                        $productos = $this->productoService->showProductos();
                        $this->pages->render('Productos/showProductos', ['productos' => $productos]);
                    } else {
                        $_SESSION['register'] = 'fail';
                        $_SESSION['errors'] = 'Contraseña incorrecta.';
                        $this->pages->render('user/login', ['userData' => $_POST['data']]);
                    }
                } catch (Exception $e) {
                    $_SESSION['register'] = 'fail';
                    $_SESSION['errors'] = 'Error al iniciar sesión: ' . $e->getMessage();
                    $this->pages->render('user/login', ['userData' => $_POST['data']]);
                }
            }
        } else {
            $this->pages->render('user/login');
        }
    }

    /**
     * Método para cerrar sesion
     * @return void
     */
    public function logout():void {
        session_unset();
        session_destroy();
        $this->pages->render('user/login');
        exit();
    }

}