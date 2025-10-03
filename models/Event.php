<?php

namespace Model;

class Event extends ActiveRecord {
    protected static $table = 'events';
    protected static $columnsDB = ['id', 'name', 'description', 'available', 'category_id', 'day_id', 'hour_id', 'speaker_id'];

    public ?int $id;
    public string $name;
    public string $description;
    public int $available;
    public ?int $category_id;
    public ?int $day_id;
    public ?int $hour_id;
    public ?int $speaker_id;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->name = $args["name"] ?? "";
        $this->description = $args["description"] ?? "";
        $this->available = isset($args["available"]) ? (int)$args["available"] : 0;
        $this->category_id = isset($args["category_id"]) && $args["category_id"] !== "" ? (int)$args["category_id"] : null;
        $this->day_id = isset($args["day_id"]) && $args["day_id"] !== "" ? (int)$args["day_id"] : null;
        $this->hour_id = isset($args["hour_id"]) && $args["hour_id"] !== "" ? (int)$args["hour_id"] : null;
        $this->speaker_id = isset($args["speaker_id"]) && $args["speaker_id"] !== "" ? (int)$args["speaker_id"] : null;
    }

    // Mensajes de validación para la creación de un evento
    public function validate_event() {
        if(!$this->name) {
            self::$alerts['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->description) {
            self::$alerts['error'][] = 'La descripción es Obligatoria';
        }
        if(!$this->category_id || !filter_var($this->category_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = 'Elige una Categoría';
        }
        if(!$this->day_id || !filter_var($this->day_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = 'Elige el Día del evento';
        }
        if(!$this->hour_id || !filter_var($this->hour_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = 'Elige la hora del evento';
        }
        if(!$this->available || !filter_var($this->available, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = 'Añade una cantidad de Lugares Disponibles';
        }
        if(!$this->speaker_id || !filter_var($this->speaker_id, FILTER_VALIDATE_INT) ) {
            self::$alerts['error'][] = 'Selecciona la persona encargada del evento';
        }
        return self::$alerts;
    }
}