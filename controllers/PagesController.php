<?php
namespace Controllers;

use MVC\Router;
use Model\Event;

class PagesController {
    public static function index(Router $router) {
        $router->render("pages/index", [
            "title" => "Inicio"
        ]);
    }

    public static function event(Router $router) {
        $router->render("pages/devwebcamp", [
            "title" => "Sobre DevWebCamp"
        ]);
    }

    public static function packages(Router $router) {
        $router->render("pages/packages", [
            "title" => "Paquetes DevWebCamp"
        ]);
    }

    public static function conferences(Router $router) {
        $events = Event::allWithJoins("hour_id", null, false);

        // Estructura multidimensional para agrupar eventos
        $formatted_events = [];

        foreach($events as $event) {
            $formatted_events[$event->day_id][$event->category_id][] = $event;
        }
    
        $router->render("pages/conferences", [
            "title" => "Conferencias & Workshops",
            "events" => $formatted_events
        ]);
    }
}