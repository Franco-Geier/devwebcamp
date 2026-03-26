<?php

namespace Model;

class Gift extends ActiveRecord {
    protected static $table = 'gifts';
    protected static $columnsDB = ['id', 'name'];
    
    public ?int $id;
    public ?string $name;
    
    public function __construct($args = []) {
        $this->id = isset($args["id"]) ? (int)$args["id"] : null;
        $this->name = $args['pay_id'] ?? '';
    }
}