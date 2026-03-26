<?php
namespace Controllers;

use Model\Event;
use Model\EventsRegisters;
use Model\Gift;
use Model\Package;
use Model\Register;
use Model\User;
use MVC\Router;

class RegisterController {
    public static function create(Router $router) {

        if(!isAuth()) {
            header("Location: /");
            return;
        }

        // Verificar si el ususario ya está registrado
        $register = Register::where("user_id", $_SESSION["id"]);
        if(isset($register) && $register->package_id === 3 || $register->package_id === 2) {
            header("Location: /ticket?id=" . urlencode($register->token));
            return;
        }

        if(isset($register) && $register->package_id === 1) {
            header("Location: /end-register/conferences");
            return;
        }

        $router->render("register/create", [
            "title" => "Finalizar Registro",
            "register" => $register
        ]);
    }

    public static function free(Router $router) {

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(!isAuth()) {
                header("Location: /login");
                return;
            }
        }

        // Verificar si el ususario ya está registrado
        $register = Register::where("user_id", $_SESSION["id"]);
        if(isset($register) && $register->package_id === 3) {
            header("Location: /ticket?id=" . urlencode($register->token));
            return;
        }

        $token = eightTokenGenerator();

        // Crear registro
        $data = [
            "package_id" => 3,
            "pay_id" => "",
            "token" => $token,
            "user_id" => $_SESSION["id"]
        ];

        $register = new Register($data);
        $result = $register->save();

        if($result) {
            header("Location: /ticket?id=" . urlencode($register->token));
            return;
        }
    }

    public static function ticket(Router $router) {

        // Validar la URL
        $id = $_GET["id"];
        if(!$id || strlen($id) !== 8) {
            header("Location: /");
            return;
        }

        // Buscarlo en la BD
        $register = Register::where("token", $id);
        if(!$register) {
            header("Location: /");
            return;
        }

        // LLenar las tablas de referencia
        $register->user = User::find($register->user_id);
        $register->package = Package::find($register->package_id);

        $router->render("register/ticket", [
            "title" => "Asistencia a DevWebCamp",
            "register" => $register
        ]);
    }

    public static function pay(Router $router) {

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(!isAuth()) {
                header("Location: /login");
                return;
            }
        }

        // Validar que POST no venga vacío
        if(empty($_POST)) {
            echo json_encode([]);
            return;
        }

        // Crear registro
        $data = $_POST;
        $data["token"] = eightTokenGenerator();
        $data["user_id"] = $_SESSION["id"];

        try {
            $register = new Register($data);
            $result = $register->save();
            echo json_encode([
                "result" => $result
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                "result" => "false"
            ]);
        }
    }

    public static function conferences(Router $router) {

        if(!isAuth()) {
            header("Location: /login");
            return;
        }

        // Validar que el usuario tenga el plan presencial
        $user_id = $_SESSION["id"];
        $register = Register::where("user_id", $user_id);

        if(isset($register) && $register->package_id === 2) {
            header("Location: /ticket?id=" . urlencode($register->token));
            return;
        }

        if($register->package_id !== 1) {
            header("Locarion: /");
            return;
        }

        // Redireccionar a boleto virtual en caso de haber finalizado su registro
        if(isset($register->gift_id) && $register->package_id === 1) {
            header("Location: /ticket?id=" . urlencode($register->token));
            return;
        }

        $events = Event::allWithJoins("hour_id", null, false);

        // Estructura multidimensional para agrupar eventos
        $formatted_events = [];

        foreach($events as $event) {
            $formatted_events[$event->day_id][$event->category_id][] = $event;
        }

        $gifts = Gift::allWithJoins("id", null, false);

        // Manejando el registro mediante $_POST
        if($_SERVER["REQUEST_METHOD"] === "POST") {

            if(!isAuth()) {
                header("Location: /");
                return;
            }

            $events = explode(",", $_POST["events"]);
            if(empty($events)) {
                echo json_encode(["result" => false]);
                return;
            }

            // Obtener el registro del usuario
            $register = Register::where("user_id", $_SESSION["id"]);
            if(!isset($register) || $register->package_id !== 1) {
                echo json_encode(["result" => false]);
                return;
            }

            $events_array = [];

            // Validar la disponibilidad de los eventos seleccionados
            foreach ($events as $event_id) {
                $event = Event::find($event_id);

                // Comprobar que el evento existe
                if(!isset($event) || $event->available === 0) {
                    echo json_encode(["result" => false]);
                    return;
                }
                $events_array[] = $event;
            }
            foreach($events_array as $event) {
                $event->available -= 1;
                $event->save();

                // Almacenar el registro
                $data = [
                    "event_id" => $event->id,
                    "register_id" => $register->id
                ];
                $register_user = new EventsRegisters($data);
                $register_user->save();
            }

            // Almacenar el regalo
            $register->sincronize(["gift_id" => $_POST["gift_id"]]);
            $result = $register->save();

            if($result) {
                echo json_encode([
                    "result" => $result,
                    "token" => $register->token
                ]);
            } else { 
                echo json_encode(["result" => false]);
            }
            return;
        }

        $router->render("register/conferences", [
            "title" => "Elige Workshops y Conferencias",
            "events" => $formatted_events,
            "gifts" => $gifts
        ]);
    }
}