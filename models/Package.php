<?php

namespace Model;

class Package extends ActiveRecord {

    protected static $table = 'packages';
    protected static $columnsDB = ['id', 'name'];

    public ?int $id;
    public string $name;

    // Mapeo de las clases css
    public function class_css() {
        $map = [
            'Presencial' => 'in-person',
            'Virtual'    => 'virtual',
            'Gratis'     => 'free'
        ];
        // Retorna la clase según el nombre en la DB, o 'free' por defecto
        return $map[ strtolower($this->name) ] ?? 'free';
    }
}