<?php

namespace Controllers;

use Models\Pedidos;
use Services\PedidosService;
use Lib\Pages;
use Exception;
use Services\ProductoService;
use Lib\Mailer;
class PedidosController
{

    private PedidosService $pedidoService;
    private ProductoService $productoService;

    private Mailer $mailer;

    private Pages $pages;

    /**
     * Constructor que inicializa Pages, PedidoService, ProductoService, Mailer
     */
    public function __construct(){
        $this->pedidoService = new PedidosService();
        $this->pages = new Pages();
        $this->productoService = new ProductoService();
        $this->mailer = new Mailer();
    }

    /**
     * Método que comprueba si se han seleccionado correctamente los productos para realizar un pedido
     * @return void
     */
    public function hacerPedido():void{
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // si no esta iniciada sesion, se redirige al formulario de login
            if(empty($_SESSION['user'])){
                $this->pages->render('user/login');
                return;
            }
            if(isset($_POST['productos']) && is_array($_POST['productos'])){
                $productos = $_POST['productos'];

                if(empty($productos)){
                    die("No se han seleccionado productos válidos para realizar el pedido.");
                }
                foreach($productos as $producto){
                    // por si los datos del producto respecto a la cantidad son inferiores a 0
                    if(!isset($producto['id'], $producto['cantidad']) || $producto['cantidad'] <= 0){
                        die("Los datos del producto son inválidos.");
                    }
                    // Creamos un objeto de tipo Producto
                    $productoInfo = $this->productoService->buscarPorId($producto['id']);
                    if (!$productoInfo){
                        die("Producto con ID {$producto['id']} no encontrado.");
                    }
                }
                $this->pages->render('Pedidos/hacerPedido', ['productos' => $productos]);
            } else{
                die("No se han enviado productos para el pedido.");
            }
        } else{
            die("No se puede acceder a esta función de esta manera.");
        }
    }

    /**
     * Método que registra la cabecera del pedido y sus lineas de pedido
     * @return void
     */
    public function registrarPedido(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {
                $pedidoData = $_POST['data'];
                // Creamos un objeto Pedido con los datos de la cabecera
                $pedido = Pedidos::fromArray($pedidoData);

                try {
                    // Iniciar la transacción
                    $this->pedidoService->transaccion();

                    // Registramos la cabecera del pedido en la base de datos
                    $pedidoId = $this->pedidoService->registrarPedido($pedido);

                    //inicializamos un array para introducir todas las lineas de pedido
                    $lineasPedido = [];

                    if (isset($pedidoData['productos']) && is_array($pedidoData['productos'])) {
                        // recorremos el $_POST con los datos de los productos para inicializar variables con sus datos e
                        // introducir esos datos dentro de lineas_pedidos
                        foreach ($pedidoData['productos'] as $producto) {
                            if (isset($producto['producto_id'], $producto['unidades'])) {
                                $productoId = $producto['producto_id'];
                                $cantidad = $producto['unidades'];
                                $nombre = $producto['nombre'];
                                $imagen = $producto['imagen'];
                                $precio = (int)$producto['precio'];

                                // Registrar la línea del pedido
                                $this->pedidoService->registrarLineaPedido($pedidoId, $productoId, $cantidad);

                                // Actualizar el stock
                                $this->pedidoService->actualizarStock($productoId, $cantidad);

                                // guardamos por cada linea de pedido un array dentro del array de lineas pedidos para posteriormente
                                // enviar un email con todas las lineas de pedido
                                $lineasPedido[] = [
                                    'producto_id' => $productoId,
                                    'nombre' => $nombre,
                                    'imagen' => $imagen,
                                    'precio' => $precio,
                                    'cantidad' => $cantidad,
                                    'total' => $precio * $cantidad,
                                ];
                            } else {
                                throw new Exception("Datos de producto incompletos.");
                            }
                        }
                    }
                    // enviamos el email y hacemos un commit si todo ha salido correcto
                    $this->mailer->enviarMail($pedido, $lineasPedido);
                    $this->pedidoService->commit();

                    $_SESSION['success'] = "Pedido registrado correctamente.";
                    $this->pages->render('Pedidos/pedidoCompletado');
                    // dejamos el carrito vacio después de hacer el pedido
                    $_SESSION['carrito'] = [];
                } catch (Exception $e) {
                    // Deshacer la transacción en caso de error
                    $this->pedidoService->rollback();

                    $_SESSION['error'] = $e->getMessage();
                    $this->pages->render('Pedidos/hacerPedido', ['errors' => $_SESSION['error']]);
                }
            } else {
                $_SESSION['register'] = 'fail';
                $this->pages->render('Pedidos/hacerPedido', ['errors' => 'No se enviaron datos de pedido.']);
            }
        } else {
            $this->pages->render('Pedidos/hacerPedido');
        }
    }


}