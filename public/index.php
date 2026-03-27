<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIEvents;
use Controllers\APIGifts;
use Controllers\APISpeakers;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\EventsController;
use Controllers\GiftsController;
use Controllers\PagesController;
use Controllers\RegisterController;
use Controllers\RegisteredController;
use Controllers\SpeakersController;
use MVC\Router;

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

// Area de administración
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/speakers', [SpeakersController::class, 'index']);
$router->get('/admin/speakers/create', [SpeakersController::class, 'create']);
$router->post('/admin/speakers/create', [SpeakersController::class, 'create']);
$router->get('/admin/speakers/edit', [SpeakersController::class, 'edit']);
$router->post('/admin/speakers/edit', [SpeakersController::class, 'edit']);
$router->post('/admin/speakers/delete', [SpeakersController::class, 'delete']);

$router->get('/admin/events', [EventsController::class, 'index']);
$router->get('/admin/events/create', [EventsController::class, 'create']);
$router->post('/admin/events/create', [EventsController::class, 'create']);
$router->get('/admin/events/edit', [EventsController::class, 'edit']);
$router->post('/admin/events/edit', [EventsController::class, 'edit']);
$router->post('/admin/events/delete', [EventsController::class, 'delete']);

$router->get('/api/events-schedule', [APIEvents::class, 'index']);
$router->get('/api/speakers', [APISpeakers::class, 'index']);
$router->get('/api/speaker', [APISpeakers::class, 'speaker']);
$router->get('/api/gifts', [APIGifts::class, 'index']);

$router->get('/admin/registered', [RegisteredController::class, 'index']);
$router->get('/admin/gifts', [GiftsController::class, 'index']);

// Registro de usuarios
$router->get('/end-register', [RegisterController::class, 'create']);
$router->post('/end-register/free', [RegisterController::class, 'free']);
$router->post('/end-register/pay', [RegisterController::class, 'pay']);
$router->get('/end-register/conferences', [RegisterController::class, 'conferences']);
$router->post('/end-register/conferences', [RegisterController::class, 'conferences']);

// Boleto virtual
$router->get("/ticket", [RegisterController::class, "ticket"]);

// Área pública
$router->get('/', [PagesController::class, 'index']);
$router->get('/devwebcamp', [PagesController::class, 'event']);
$router->get('/packages', [PagesController::class, 'packages']);
$router->get('/workshops-conferences', [PagesController::class, 'conferences']);
$router->get('/404', [PagesController::class, 'error']);

$router->validateRoutes();