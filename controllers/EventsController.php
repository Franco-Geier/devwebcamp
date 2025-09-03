<?php
namespace Controllers;

use MVC\Router;

class EventsController {
    public static function index(Router $router) {
        $router->render("admin/events/index", [
            "tittle" => "Conferencias Y Workshops"
        ]);
    }
}