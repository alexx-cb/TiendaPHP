<?php

namespace Controllers;
use Lib\Pages;
class ErrorController
{

    /**
     * Método que muestra como error una pagina no encontrada
     * @return void
     */
    public static function error404():void{
        $pages = new Pages;
        $pages->render('error/error404', ['titulo' => 'Pagina no encontrada']);

    }
}