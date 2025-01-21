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

    public function __construct(){
        $this->pedidoService = new PedidosService();
        $this->pages = new Pages();
        $this->productoService = new ProductoService();
        $this->mailer = new Mailer();
    }

    public function hacerPedido(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_SESSION['user'])) {
                $this->pages->render('user/login');
                return;
            }
            if (isset($_POST['productos']) && is_array($_POST['productos'])) {
                $productos = $_POST['productos'];

                if (empty($productos)) {
                    die("No se han seleccionado productos válidos para realizar el pedido.");
                }
                foreach ($productos as $producto) {
                    if (!isset($producto['id'], $producto['cantidad']) || $producto['cantidad'] <= 0) {
                        die("Los datos del producto son inválidos.");
                    }
                    $productoInfo = $this->productoService->buscarPorId($producto['id']);
                    if (!$productoInfo) {
                        die("Producto con ID {$producto['id']} no encontrado.");
                    }
                }
                $this->pages->render('Pedidos/hacerPedido', ['productos' => $productos]);
            } else {
                die("No se han enviado productos para el pedido.");
            }
        } else {
            die("No se puede acceder a esta función de esta manera.");
        }
    }

    public function registrarPedido(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {
                $pedidoData = $_POST['data'];
                $pedido = Pedidos::fromArray($pedidoData);

                try {
                    // Iniciar la transacción
                    $this->pedidoService->transaccion();

                    $pedidoId = $this->pedidoService->registrarPedido($pedido);

                    $lineasPedido = [];

                    if (isset($pedidoData['productos']) && is_array($pedidoData['productos'])) {
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
                    $this->mailer->enviarMail($pedido, $lineasPedido);
                    $this->pedidoService->commit();

                    $_SESSION['success'] = "Pedido registrado correctamente.";
                    $this->pages->render('Pedidos/pedidoCompletado');
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