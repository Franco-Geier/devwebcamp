<?php
namespace Controllers;

use Classes\Pagination;
use Model\Speaker;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SpeakersController {
    public static function index(Router $router) {
        $current_page = $_GET["page"] ?? 1;
        $current_page = filter_var($current_page, FILTER_VALIDATE_INT);
        if($current_page === false || $current_page < 1) {
            header("Location: /admin/speakers?page=1");
            exit;
        }

        $registrations_per_page = 10;
        $total_registrations = Speaker::total();
        $pagination = new Pagination($current_page, $registrations_per_page, $total_registrations, 5);

        if($pagination->total_pages() < $current_page) {
            header("Location: /admin/speakers?page=1");
        }

        $speakers = Speaker::paginate($registrations_per_page, $pagination->offset());

        if(!isAdmin()) {
            header("Location: /login");
        }

        $router->render("admin/speakers/index", [
            "tittle" => "Ponentes / Conferencistas",
            "speakers" => $speakers,
            "pagination" =>$pagination->pagination()
        ]);
    }

    public static function create(Router $router) {
        if(!isAdmin()) {
            header("Location: /login");
        }
        $alerts = [];
        $speaker = new Speaker;

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(!isAdmin()) {
                header("Location: /login");
            }

            if(!empty($_FILES["image"]["tmp_name"])) {
                if(!is_dir(FOLDER_IMAGES)) { // Si no existe el directorio, lo crea
                    mkdir(FOLDER_IMAGES, 0777, true);
                }

                $manager = new ImageManager(new Driver()); // Crear el ImageManafer con el Driver
                $image = $manager->read($_FILES["image"]["tmp_name"]); // Leer la imagen
                 
                // Obtener dimensiones actuales
                $width = $image->width();
                $height = $image->height();
                $minDimension = min($width, $height);

                if($minDimension < 600) {
                    $image->contain(800, 800, 'ffffff'); // Imagen pequeña: añadir márgenes blancos
                } else {
                    $image->cover(800, 800);
                }

                $image_name = md5(uniqid(rand(), true)); // Generar nombre único
                $_POST["image"] = $image_name;

                $png_encoded = $image->toPng(); // Generar PNG
                $webp_encoded = $image->toWebp(80); // Generar WebP 
                $avif_encoded = $image->toAvif(80); // Generar AVIF
            }
            $_POST['social_networks'] = json_encode($_POST['social_networks'], JSON_UNESCAPED_SLASHES);
            $speaker->sincronize($_POST);
            $alerts = $speaker->validateSpeaker();
        
            if(empty($alerts)) {
                // Guardar imagenes solo si se procesaron
                if(isset($png_encoded)) {
                    file_put_contents(FOLDER_IMAGES . "/" . $image_name . ".png", $png_encoded);
                    file_put_contents(FOLDER_IMAGES . "/" . $image_name . ".webp", $webp_encoded);
                    file_put_contents(FOLDER_IMAGES . "/" . $image_name . ".avif", $avif_encoded);
                }
                
                $result = $speaker->save();

                if($result) {
                    header("Location: /admin/speakers");
                }
            }
        }
        
        $router->render("admin/speakers/create", [
            "tittle" => "Registrar Ponente",
            "alerts" => $alerts,
            "speaker" => $speaker,
            "social_networks" => json_decode($speaker->social_networks)
        ]);
    }

    public static function edit(Router $router) {
        if(!isAdmin()) {
            header("Location: /login");
        }

        $alerts = [];
        $id = validateOrRedirection("/admin/speakers");
        $speaker = Speaker::find($id);

        if(!$speaker) {
            header("Location: /admin/speakers");
        }

        $speaker->current_image = $speaker->image;
        $old_image = $speaker->current_image; // Guardar imagen anterior

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(!isAdmin()) {
                header("Location: /login");
            }

            $new_image_uploaded = false;

            if(!empty($_FILES["image"]["tmp_name"])) {
                if(!is_dir(FOLDER_IMAGES)) { // Si no existe el directorio, lo crea
                    mkdir(FOLDER_IMAGES, 0777, true);
                }

                $manager = new ImageManager(new Driver()); // Crear el ImageManafer con el Driver
                $image = $manager->read($_FILES["image"]["tmp_name"]); // Leer la imagen
                
                // Obtener dimensiones actuales
                $width = $image->width();
                $height = $image->height();
                $minDimension = min($width, $height);

                if($minDimension < 600) {
                    $image->contain(800, 800, 'ffffff'); // Imagen pequeña: añadir márgenes blancos
                } else {
                    $image->cover(800, 800);
                }

                $image_name = md5(uniqid(rand(), true)); // Generar nombre único
                $_POST["image"] = $image_name;

                $png_encoded = $image->toPng(); // Generar PNG
                $webp_encoded = $image->toWebp(80); // Generar WebP 
                $avif_encoded = $image->toAvif(80); // Generar AVIF

                $new_image_uploaded = true;
            } else {
                $_POST["image"] = $speaker->current_image;
            }
            $_POST['social_networks'] = json_encode($_POST['social_networks'], JSON_UNESCAPED_SLASHES);
            $speaker->sincronize($_POST);
            $alerts = $speaker->validateSpeaker();

            if(empty($alerts)) {
                // Guardar imagenes solo si se procesaron
                if(isset($png_encoded)) {
                    file_put_contents(FOLDER_IMAGES . "/" . $image_name . ".png", $png_encoded);
                    file_put_contents(FOLDER_IMAGES . "/" . $image_name . ".webp", $webp_encoded);
                    file_put_contents(FOLDER_IMAGES . "/" . $image_name . ".avif", $avif_encoded);

                    if ($new_image_uploaded && $old_image && $old_image !== $image_name) {
                        $speaker::deleteImageFiles($old_image);
                    }
                }
                
                $result = $speaker->save();

                if($result) {
                    header("Location: /admin/speakers");
                }
            }
        }

        $router->render("admin/speakers/edit", [
            "tittle" => "Actualizar Ponente",
            "alerts" => $alerts,
            "speaker" => $speaker,
            "social_networks" => json_decode($speaker->social_networks)
        ]);
    }

    public static function delete(Router $router) {
        if(!isAdmin()) {
            header("Location: /login");
        }
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $speaker = Speaker::find($id);

            if(!isset($speaker)) {
                header("Location: /admin/speakers");
            }

            if($speaker->image) {
                $speaker::deleteImageFiles($speaker->image);
            }

            $result = $speaker->delete();

            if($result) {
                header("Location: /admin/speakers");
            }
        }
    }
}