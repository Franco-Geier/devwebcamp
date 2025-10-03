<?php
namespace Controllers;

use Model\Category;
use Model\Day;
use Model\Event;
use Model\Hour;
use MVC\Router;

class EventsController {
    public static function index(Router $router) {
        $router->render("admin/events/index", [
            "tittle" => "Conferencias Y Workshops"
        ]);
    }

    public static function create(Router $router) {
        $alerts = [];
        $categories = Category::allWithJoins("name", null, false);
        $days = Day::allWithJoins("id", null, false);
        $hours = Hour::allWithJoins("id", null, false);
        $event = new Event;

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $event->sincronize($_POST);
            $alerts = $event->validate_event();

            if(empty($alerts)) {
                $result = $event->save();
                if($result) {
                    header("Location: /admin/events");
                }
            }
        }

        $router->render("admin/events/create", [
            "tittle" => "Registrar Evento",
            "alerts" => $alerts,
            "categories" => $categories,
            "days" => $days,
            "hours" => $hours,
            "event" => $event
        ]);
    }
}