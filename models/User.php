<?php

namespace Model;

class User extends ActiveRecord {
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'name', 'last_name', 'email', 'password', 'confirmed', 'token', 'admin'];
    
    public ?int $id;
    public string $name;
    public string $last_name;
    public string $email;
    public string $password;
    public string $password2;
    public string $current_password;
    public string $new_password;
    public int $confirmed;
    public string $token;
    public int $admin;
    
    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->name = $args['name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->current_password = $args["current_password"] ?? "";
        $this->new_password = $args["new_password"] ?? "";
        $this->confirmed = isset($args['confirmed']) ? (int)$args['confirmed'] : 0;
        $this->token = $args['token'] ?? '';
        $this->admin = isset($args['admin']) ? (int)$args['admin'] : 0;
    }

    protected function validatePasswordRequired(): void {
        if(!$this->password) {
            self::$alerts["error"][] = "El password no puede ir vacío";
        }
    }

    protected function validatePasswordSecure(): void {
        if(mb_strlen($this->password) < 8 || mb_strlen($this->password) > 128) {
            self::$alerts["error"][] = "El password debe contener entre 8 y 128 caracteres";
        } elseif($this->password !== $this->password2) {
            self::$alerts["error"][] = "Los passwords no coinciden";
        } else {
            if(!preg_match('/[A-Z]/', $this->password)) {
                self::$alerts["error"][] = "El password debe incluir al menos una letra mayúscula";
            }
            if(!preg_match('/[a-z]/', $this->password)) {
                self::$alerts["error"][] = "El password debe incluir al menos una letra minúscula";
            }
            if(!preg_match('/[0-9]/', $this->password)) {
                self::$alerts["error"][] = "El password debe incluir al menos un número";
            }
            if(!preg_match('/[^a-zA-Z0-9]/', $this->password)) {
                self::$alerts["error"][] = "El password debe incluir al menos un carácter especial";
            }
        }
    }

    protected function validateEmailLogic(): void {
        if(!$this->email) {
            self::$alerts["error"][] = "El email del usuario es obligatorio";
        } elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts["error"][] = "El email no es válido.";
        }
    }

    protected function validateNameLogic(): void {
        if(!$this->name) {
            self::$alerts["error"][] = "El nombre es obligatorio";
        } elseif(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s'-]+$/", $this->name)) {
            self::$alerts["error"][] = "El nombre solo puede contener letras, números, espacios, apóstrofes y guiones.";
        } elseif(mb_strlen($this->name) > 30) {
            self::$alerts["error"][] = "El nombre debe tener hasta 30 caracteres.";
        }

        if(!$this->last_name) {
            self::$alerts['error'][] = 'El apellido es obligatorio';
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s'-]+$/", $this->last_name)) {
            self::$alerts["error"][] = "El apellido solo puede contener letras, espacios, apóstrofes y guiones.";
        } elseif (mb_strlen($this->last_name) > 30) {
            self::$alerts["error"][] = "El apellido debe tener hasta 30 caracteres.";
        }
    }

    protected function validateLoginLogic(): void {
        $this->validateEmailLogic();
        $this->validatePasswordRequired();
    }

    // Validación para cuentas nuevas
    public function validateNewAccount() {
        $this->validateNameLogic();
        $this->validateEmailLogic();
        $this->validatePasswordRequired();
        $this->validatePasswordSecure();
        return self::$alerts;
    }

    public function validateEditAccount(): array {
        $this->validateNameLogic();
        $this->validateEmailLogic();
        return self::$alerts;
    }

    // Valida el login del usuario y retorna un array de alertas
    public function validateLogin(): array {
        $this->validateLoginLogic();
        return self::$alerts;
    }

    // Valida un email y retorna un array de alertas
    public function validateEmail(): array {
        $this->validateEmailLogic();
        return self::$alerts;
    }

    // Valida un password y retorna un array de alertas
    public function validatePassword(): array {
        $this->validatePasswordRequired();
        $this->validatePasswordSecure();
        return self::$alerts;
    }

    public function new_password(): array {
        if(!$this->current_password) {
            self::$alerts["error"][] = "El password actual no puede ir vacío";
        }

        if(!$this->new_password) {
            self::$alerts["error"][] = "El password nuevo no puede ir vacío";
        }
        if(mb_strlen($this->new_password) < 8 || mb_strlen($this->new_password) > 128) {
            self::$alerts["error"][] = "El password debe contener entre 8 y 128 caracteres";
        }
        if(!preg_match('/[A-Z]/', $this->new_password)) {
                self::$alerts["error"][] = "El password debe incluir al menos una letra mayúscula";
        }
        if(!preg_match('/[a-z]/', $this->new_password)) {
            self::$alerts["error"][] = "El password debe incluir al menos una letra minúscula";
        }
        if(!preg_match('/[0-9]/', $this->new_password)) {
            self::$alerts["error"][] = "El password debe incluir al menos un número";
        }
        if(!preg_match('/[^a-zA-Z0-9]/', $this->new_password)) {
            self::$alerts["error"][] = "El password debe incluir al menos un carácter especial";
        }
        return self::$alerts;
    }

    public function hashPassword(): void {
        $pepper = PEPPER;
        $peppered = hash_hmac("sha256", $this->password, $pepper);
            
        $options = [
            "memory_cost" => 1 << 17, // 128 MB
            "time_cost" => 4,
            "threads" => 2
        ];

        $this->password = password_hash($peppered, PASSWORD_ARGON2ID, $options);
    }

    public static function verifyPassword(string $input, string $hash): bool {
        $pepper = PEPPER;
        $peppered = hash_hmac("sha256", $input, $pepper);
        return password_verify($peppered, $hash);
    }
}