<?php
namespace Controllers;

use Model\Event;
use Model\Register;
use Model\User;
use MVC\Router;

class DashboardController {
    public static function index(Router $router) {
        
        // Obtener ultimos registros
        $registers = Register::allWithJoins("id", 5);
        foreach ($registers as $register) {
            $register->user = User::find($register->user_id);    
        }

        // Calcular los ingresos
        $virtual = Register::total("package_id", 2);
        $in_person = Register::total("package_id", 1);
        $income = ($virtual * 46.41) + ($in_person * 189.54);

        // Obtener eventos con más y menos lugares disponibles
        $fewer_available = Event::allWithJoins("available", 5, false);
        $more_available = Event::allWithJoins("available", 5);

        $router->render("admin/dashboard/index", [
            "title" => "Panel de administración",
            "registers" => $registers,
            "income" => $income,
            "fewer_available" => $fewer_available,
            "more_available" => $more_available
        ]);
    }
}