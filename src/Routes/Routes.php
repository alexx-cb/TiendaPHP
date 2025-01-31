<?php

namespace Routes;
use Controllers\AuthController;
use Controllers\CategoriaController;
use Controllers\ErrorController;
use Controllers\PedidosController;
use Controllers\ProductoController;
use Controllers\CarritoController;
use Lib\Router;
use Lib\Security;

class Routes
{

    public static function index(){

        /* ROUTES POR GET*/

        Router::add('GET','/',function(){
            (new ProductoController())->showProductos();
        });

        Router::add('GET','Auth/register',function(){
            (new AuthController())->register();
        });

        Router::add('GET','Auth/login',function(){
            (new AuthController())->login();
        });

        Router::add('GET','error',function(){
            ErrorController::error404();
        });

        Router::add('GET','Auth/logout',function(){
            (new AuthController())->logout();
        });

        Router::add('GET','Productos/newProducto',function(){
            (new ProductoController())->newProducto();
        });

        Router::add('GET','Productos/showProductos',function(){
            (new ProductoController())->showProductos();
        });

        Router::add('GET','Categorias/newCategoria',function(){
            (new CategoriaController())->newCategoria();
        });

        Router::add('GET','Carrito/addCarrito',function(){
            (new CarritoController())->addCarrito();
        });

        Router::add('GET','Carrito/verCarrito',function(){
            (new CarritoController())->showCarrito();
        });

        Router::add('GET','Carrito/sumarProducto',function(){
            (new CarritoController())->sumarProducto();
        });

        Router::add('GET','Carrito/restarProducto',function(){
            (new CarritoController())->restarProducto();
        });

        Router::add('GET','Pedido/hacerPedido',function(){
            (new PedidosController())->hacerPedido();
        });

        Router::add('GET','Pedido/registrarPedido',function(){
            (new PedidosController())->registrarPedido();
        });

        Router::add('GET', 'Auth/confirmar-cuenta/:token', function($token){
            (new AuthController())->confirmarCuenta($token);
        });


        /* ROUTES POR POST*/

        Router::add('POST','/',function(){
            (new ProductoController())->showProductos();
        });

        Router::add('POST','Auth/register',function(){
            (new AuthController())->register();
        });

        Router::add('POST','error',function(){
            ErrorController::error404();
        });

        Router::add('POST','Auth/login',function(){
            (new AuthController())->login();
        });

        Router::add('POST','Auth/logout',function(){
            (new AuthController())->logout();
        });

        Router::add('POST','Productos/newProducto',function(){
            (new ProductoController())->newProducto();
        });

        Router::add('POST','Productos/showProductos',function(){
            (new ProductoController())->showProductos();
        });

        Router::add('POST','Categorias/newCategoria',function(){
            (new CategoriaController())->newCategoria();
        });

        Router::add('POST','Carrito/addCarrito',function(){
            (new CarritoController())->addCarrito();
        });

        Router::add('POST','Carrito/verCarrito',function(){
            (new CarritoController())->showCarrito();
        });

        Router::add('POST','Carrito/sumarProducto',function(){
            (new CarritoController())->sumarProducto();
        });

        Router::add('POST','Carrito/restarProducto',function(){
            (new CarritoController())->restarProducto();
        });

        Router::add('POST','Pedido/hacerPedido',function(){
            (new PedidosController())->hacerPedido();
        });

        Router::add('POST','Pedido/registrarPedido',function(){
            (new PedidosController())->registrarPedido();
        });

        Router::add('POST','Productos/editarProductoForm',function(){
            (new ProductoController())->renderizarEditarProducto();
        });

        Router::add('POST','Productos/eliminarProducto',function(){
            (new ProductoController())->eliminarProducto();
        });

        Router::add('POST','Productos/editarProducto',function(){
            (new ProductoController())->editarProducto();
        });


        Router::dispatch();
    }

}