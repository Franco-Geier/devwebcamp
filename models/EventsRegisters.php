<?php

namespace Model;

class EventsRegisters extends ActiveRecord {
    protected static $table = 'events_registers';
    protected static $columnsDB = ['id', 'event_id', 'register_id'];

    public ?int $id;
    public ?int $event_id;
    public ?int $register_id;

    public function __construct($args = []) {
        $this->id = isset($args["id"]) ? (int)$args["id"] : null;
        $this->event_id = isset($args['event_id']) && $args['event_id'] !== "" ? (int)$args['event_id'] : null;
        $this->register_id = isset($args['register_id']) && $args['register_id'] !== "" ? (int)$args['register_id'] : null;
    }
}