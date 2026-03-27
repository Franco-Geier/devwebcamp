<?php
namespace Controllers;

use Classes\Pagination;
use Model\Package;
use Model\Register;
use Model\User;
use MVC\Router;

class RegisteredController {

    public static function index(Router $router) {

        if(!isAdmin()) {
            header("Location: /login");
        }

        $current_page = $_GET["page"] ?? 1;
        $current_page = filter_var($current_page, FILTER_VALIDATE_INT);
        if($current_page === false || $current_page < 1) {
            header("Location: /admin/registered?page=1");
            exit;
        }

        $registrations_per_page = 10;
        $total_registrations = Register::total();
        $pagination = new Pagination($current_page, $registrations_per_page, $total_registrations, 5);

        if($pagination->total_pages() < $current_page) {
            header("Location: /admin/registered?page=1");
        }

        $registers = Register::paginate($registrations_per_page, $pagination->offset());

        foreach($registers as $register) {
            $register->user = User::find($register->user_id);
            $register->package = Package::find($register->package_id);
        }

        $router->render("admin/registered/index", [
            "title" => "Usuarios Registrados",
            "registers" => $registers,
            "pagination" => $pagination->pagination()
        ]);
    }
}