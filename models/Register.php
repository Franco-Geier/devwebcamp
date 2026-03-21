<?php

namespace Model;

class Register extends ActiveRecord {
    protected static $table = 'registers';
    protected static $columnsDB = ['id', 'package_id', 'pay_id', 'token', 'user_id'];
    
    public ?int $id;
    public ?int $package_id;
    public ?string $pay_id;
    public ?string $token;
    public ?int $user_id;

    // Definir las propiedades para los objetos relacionados
    public $user = null;
    public $package = null; 
    
    public function __construct($args = []) {
        // $this->id = $args["id"] ?? null;
        // $this->package_id = $args['package_id'] ?? null;
        // $this->pay_id = $args['pay_id'] ?? '';
        // $this->token = $args['token'] ?? '';
        // $this->user_id = $args['user_id'] ?? null;

        $this->id = isset($args["id"]) ? (int)$args["id"] : null;
        $this->package_id = isset($args['package_id']) && $args['package_id'] !== "" ? (int)$args['package_id'] : null; 
        $this->pay_id = $args['pay_id'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->user_id = isset($args['user_id']) && $args['user_id'] !== "" ? (int)$args['user_id'] : null;
    }
}