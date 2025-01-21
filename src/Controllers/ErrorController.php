<?php

namespace Controllers;
use Lib\Pages;
class ErrorController
{

    public static function error404():void{
        $pages = new Pages;
        $pages->render('error/error404', ['titulo' => 'Pagina no encontrada']);

    }
}