<?php
declare(strict_types=1);
define("FOLDER_IMAGES", $_SERVER["DOCUMENT_ROOT"] . "/img/speakers");

function debug(mixed $variable): void {
    echo "<pre>";
        var_dump($variable);
    echo "</pre>";
    exit;
}

// Función que revisa que el usuario este autenticado
// function isAuth(): void {
//     if(!isset($_SESSION['login'])) {
//         header('Location: /');
//     }
// }

function isAuth(): bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION["name"]) && !empty($_SESSION);
}

function isAdmin(): bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION["admin"]) && !empty($_SESSION["admin"]);
}

// Escapar/Sanitizar HTML
function s(?string $html): string {
    return htmlspecialchars($html ?? "");
}

// Muestra los mensajes
function showNotification(int $code): string|false {
    return match($code) {
        1 => "Creado Correctamente",
        2 => "Actualizado Correctamente",
        3 => "Eliminado Correctamente",
        default => false,
    };
}
    
function validateOrRedirection(string $url): int {
    // Validar la URL por ID válido
    $id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT);
    if(!$id) {
        header("Location: $url");
        exit;
    }
    return $id;
}

// Genera un token de 32 caracteres
function generateToken(): string {
    return md5(uniqid((string)rand(), true));
}

// Función que muestra la página actual
function currentPage($path): bool {
    return str_contains($_SERVER["PATH_INFO"], $path) ? true : false;
}