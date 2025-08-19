<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;

$router = new Router();

// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);

// Formulario de olvide mi password
$router->get('/forgot', [AuthController::class, 'forgot']);
$router->post('/forgot', [AuthController::class, 'forgot']);

// Colocar el nuevo password
$router->get('/restore', [AuthController::class, 'restore']);
$router->post('/restore', [AuthController::class, 'restore']);

// Confirmación de Cuenta
$router->get('/message', [AuthController::class, 'message']);
$router->get('/confirm-account', [AuthController::class, 'confirm']);


$router->validateRoutes();