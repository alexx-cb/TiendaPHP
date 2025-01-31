<?php

namespace Lib;



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Models\Pedidos;
use Models\User;
use Services\UserService;
use Lib\Security;

class Mailer
{

    private UserService $userService;


    public function __construct(){
        $this->userService = new UserService();

    }

    public function emailToken(User $usuario, string $token):void{
        try{

            $usuarioEmail = $usuario->getEmail();
            $usuarioNombre = $usuario->getNombre();
            $usuarioApellido = $usuario->getApellido();



            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $_ENV['MAILHOST'];
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Username = $_ENV['USERMAIL'];
            $mail->Password = $_ENV['MAILPASSWORD'];

            $mail->setFrom($_ENV['USERMAIL'], $_ENV['MAILNAME']. ' '. $_ENV['MAILSURNAME']);
            $mail->addReplyTo($_ENV['USERMAIL'], $_ENV['MAILNAME']. ' '. $_ENV['MAILSURNAME']);

            $mail->addAddress($usuarioEmail, $usuarioNombre . ' ' . $usuarioApellido);

            $mail->isHTML(true);

            $mail->Subject = " Confirmacion de Cuenta";
            $mail->AltBody = " Confirmacion de Cuenta";


            $contenido = "<h1>Confirmacion de Cuenta</h1>";
            $contenido .= "<p>Para confirmar su cuenta pulse el siguiente enlace</p>";
            $contenido .= "<a href='" . BASE_URL . "Auth/confirmar-cuenta/{$token}'>Confirmar cuenta</a>";


            $mail->Body = $contenido;
            $mail->send();

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function enviarMail(Pedidos $pedido, array $lineasPedido):void{
        try{
            $usuarioId = $pedido->getUsuarioId();
            $usuario = $this->userService->getUserById($usuarioId);

            $usuarioNombre = $usuario->getNombre();
            $usuarioApellido = $usuario->getApellido();
            $usuarioEmail = $usuario->getEmail();


            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $_ENV['MAILHOST'];
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Username = $_ENV['USERMAIL'];
            $mail->Password = $_ENV['MAILPASSWORD'];


            $mail->setFrom($_ENV['USERMAIL'], $_ENV['MAILNAME']. ' '. $_ENV['MAILSURNAME']);
            $mail->addReplyTo($_ENV['USERMAIL'], $_ENV['MAILNAME']. ' '. $_ENV['MAILSURNAME']);

            $mail->addAddress($usuarioEmail, $usuarioNombre.' '.$usuarioApellido);

            $mail->isHTML(true);

            $mail->Subject = "Resumen de tu pedido #{$pedido->getId()}";
            $mail->AltBody = "Resumen de tu pedido";


            $contenido = "<h1>Gracias por tu pedido</h1>";
            $contenido .= "<p>Detalles del pedido:</p>";
            $contenido .= "<ul>";
            foreach ($lineasPedido as $linea) {
                $contenido .= "<li>";
                $contenido .= "<img src='{$linea['imagen']}' alt='{$linea['nombre']}' style='width:50px; height:50px; vertical-align:middle;' />";
                $contenido .= "<strong>{$linea['nombre']}</strong> - ";
                $contenido .= "Cantidad: {$linea['cantidad']}, ";
                $contenido .= "Precio unitario: {$linea['precio']} €, ";
                $contenido .= "Total: {$linea['total']} €";
                $contenido .= "</li>";
            }
            $contenido .= "</ul>";

            $mail->Body = $contenido;

            $mail->send();

            $_SESSION['mail'] = "Correo de confirmacion enviado correctamente";
        }catch (Exception $e) {
            $_SESSION['mail'] = "Hubo un error al enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}