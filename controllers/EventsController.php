<?php
namespace Controllers;

use Classes\Pagination;
use Model\Category;
use Model\Day;
use Model\Event;
use Model\Hour;
use MVC\Router;

class EventsController {
    public static function index(Router $router) {
        if(!isAdmin()) {
            header("Location: /login");
        }

        $current_page = $_GET["page"] ?? 1;
        $current_page = filter_var($current_page, FILTER_VALIDATE_INT);
        
        if($current_page === false || $current_page < 1) {
            header("Location: /admin/events?page=1");
            exit;
        }

        $registrations_per_page = 10;
        $total_registrations = Event::total();
        $pagination = new Pagination($current_page, $registrations_per_page, $total_registrations, 5);

        if($pagination->total_pages() < $current_page) {
            header("Location: /admin/events?page=1");
        }

        $events = Event::paginate($registrations_per_page, $pagination->offset());

        $router->render("admin/events/index", [
            "title" => "Conferencias Y Workshops",
            "events" => $events,
            "pagination" => $pagination->pagination(),
        ]);
    }

    public static function create(Router $router) {
        if(!isAdmin()) {
            header("Location: /login");
        }

        $alerts = [];
        $categories = Category::allWithJoins("name", null, false);
        $days = Day::allWithJoins("id", null, false);
        $hours = Hour::allWithJoins("id", null, false);
        $event = new Event;

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(!isAdmin()) {
                header("Location: /login");
            }
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
            "title" => "Registrar Evento",
            "alerts" => $alerts,
            "categories" => $categories,
            "days" => $days,
            "hours" => $hours,
            "event" => $event
        ]);
    }

    public static function edit(Router $router) {
        if(!isAdmin()) {
            header("Location: /login");
        }

        $alerts = [];
        
        $id = $_GET["id"];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) {
            header("Location: /admin/events");
        }

        $categories = Category::allWithJoins("name", null, false);
        $days = Day::allWithJoins("id", null, false);
        $hours = Hour::allWithJoins("id", null, false);

        $event = Event::find($id);
        if(!$event) {
            header("Location: /admin/events");
        }

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(!isAdmin()) {
                header("Location: /login");
            }

            $event->sincronize($_POST);
            $alerts = $event->validate_event();

            if(empty($alerts)) {
                $result = $event->save();
                if($result) {
                    header("Location: /admin/events");
                }
            }
        }

        $router->render("admin/events/edit", [
            "title" => "Editar Evento",
            "alerts" => $alerts,
            "categories" => $categories,
            "days" => $days,
            "hours" => $hours,
            "event" => $event
        ]);
    }

    public static function delete() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(!isAdmin()) {
                header("Location: /login");
            }
            $id = $_POST["id"];
            $event = Event::find($id);

            if(!isset($event)) {
                header("Location: /admin/events");
            }

            $result = $event->delete();

            if($result) {
                header("Location: /admin/events");
            }
        }
    }
}