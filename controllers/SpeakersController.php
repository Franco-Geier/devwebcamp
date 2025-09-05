<?php
namespace Controllers;

use Model\Speaker;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SpeakersController {
    public static function index(Router $router) {
        $router->render("admin/speakers/index", [
            "tittle" => "Ponentes / Conferencistas"
        ]);
    }

    public static function create(Router $router) {
        $alerts = [];
        $speaker = new Speaker;

        if($_SERVER["REQUEST_METHOD"] === "POST") {
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
            'speaker' => $speaker
        ]);
    }
}