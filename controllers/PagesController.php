<?php
namespace Controllers;

use Model\Event;
use Model\Speaker;
use MVC\Router;

class PagesController {
    public static function index(Router $router) {
        $events = Event::allWithJoins("hour_id", null, false);

        // Estructura multidimensional para agrupar eventos
        $formatted_events = [];

        foreach($events as $event) {
            $formatted_events[$event->day_id][$event->category_id][] = $event;
        }

        // Obtener el total de cada bloque
        $speakers_total = Speaker::total();
        $conferences_total = Event::total("category_id", 1);
        $workshops_total = Event::total("category_id", 2);
        
        // Obtener todos los ponentes
        $speakers = Speaker::allWithJoins();

        $router->render("pages/index", [
            "title" => "Workshops & Conferencias",
            "events" => $formatted_events,
            "speakers_total" => $speakers_total,
            "conferences_total" => $conferences_total,
            "workshops_total" => $workshops_total,
            "speakers" => $speakers
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

    public static function error(Router $router) {

        $router->render("pages/error", [
            "title" => "Página no encontrada"
        ]);
    }
}