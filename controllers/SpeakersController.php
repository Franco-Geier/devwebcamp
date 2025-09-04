<?php
namespace Controllers;

use MVC\Router;

class SpeakersController {
    public static function index(Router $router) {
        $router->render("admin/speakers/index", [
            "tittle" => "Ponentes / Conferencistas"
        ]);
    }

    public static function create(Router $router) {
        $alerts = [];
        
        $router->render("admin/speakers/create", [
            "tittle" => "Registrar Ponente",
            "alerts" => $alerts
        ]);
    }
}