<?php

namespace Model;

class Speaker extends ActiveRecord {
    protected static $table = 'speakers';
    protected static $columnsDB = ['id', 'name', 'last_name', 'city', 'country', 'image', 'tags', 'social_networks'];
    
    public ?int $id;
    public string $name;
    public string $last_name;
    public string $city;
    public string $country;
    public string $image;
    public string $current_image;
    public string $tags;
    public string $social_networks;
    
    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->name = $args['name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->city = $args['city'] ?? '';
        $this->country = $args['country'] ?? '';
        $this->image = $args['image'] ?? '';
        $this->current_image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->social_networks = $args['social_networks'] ?? '';
    }

    public function validateSpeaker() {
        if(!$this->name) {
            self::$alerts['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->last_name) {
            self::$alerts['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->city) {
            self::$alerts['error'][] = 'El Campo Ciudad es Obligatorio';
        }
        if(!$this->country) {
            self::$alerts['error'][] = 'El Campo País es Obligatorio';
        }
        if(!$this->image) {
            self::$alerts['error'][] = 'La imagen es obligatoria';
        }
        if(!$this->tags) {
            self::$alerts['error'][] = 'El Campo áreas es obligatorio';
        }
        return self::$alerts;
    }

    public static function deleteImageFiles($imageName) {
        if(empty($imageName)) return;
            $extensions = ['png', 'webp', 'avif'];
        
            foreach ($extensions as $ext) {
                $filePath = FOLDER_IMAGES . "/" . $imageName . "." . $ext;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
    }
}