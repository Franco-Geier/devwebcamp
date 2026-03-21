<?php
namespace Controllers;

use Model\Package;
use Model\Register;
use Model\User;
use MVC\Router;

class RegisterController {
    public static function create(Router $router) {

        if(!isAuth()) {
            header("Location: /");
        }

        // Verificar si el ususario ya está registrado
        $register = Register::where("user_id", $_SESSION["id"]);
        if(isset($register) && $register->package_id === 3) {
            header("Location: /ticket?id=" . urlencode($register->token));
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
            }
        }

        // Verificar si el ususario ya está registrado
        $register = Register::where("user_id", $_SESSION["id"]);
        if(isset($register) && $register->package_id === 3) {
            header("Location: /ticket?id=" . urlencode($register->token));
        }

        $token = eightTokenGenerator();

        // Crear registro
        $data = array(
            "package_id" => 3,
            "pay_id" => "",
            "token" => $token,
            "user_id" => $_SESSION["id"]
        );

        $register = new Register($data);
        $result = $register->save();

        if($result) {
            header("Location: /ticket?id=" . urlencode($register->token));
        }
    }

    public static function ticket(Router $router) {

        // Validar la URL
        $id = $_GET["id"];
        if(!$id || strlen($id) !== 8) {
            header("Location: /");
        }

        // Buscarlo en la BD
        $register = Register::where("token", $id);
        if(!$register) {
            header("Location: /");
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
}