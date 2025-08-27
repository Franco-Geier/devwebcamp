<?php

namespace Model;

class User extends ActiveRecord {
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'name', 'lastName', 'email', 'password', 'confirmed', 'token', 'admin'];
    
    public ?int $id;
    public string $name;
    public string $lastName;
    public string $email;
    public string $password;
    public string $password2;
    public int $confirmed;
    public string $token;
    public int $admin;
    
    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->name = $args['name'] ?? '';
        $this->lastName = $args['lastName'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmed = isset($args['confirmed']) ? (int)$args['confirmed'] : 0;
        $this->token = $args['token'] ?? '';
        $this->admin = isset($args['admin']) ? (int)$args['admin'] : 0;
    }

    // // Validar el Login de Usuarios
    // public function validarLogin() {
    //     if(!$this->email) {
    //         self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
    //     }
    //     if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
    //         self::$alertas['error'][] = 'Email no válido';
    //     }
    //     if(!$this->password) {
    //         self::$alertas['error'][] = 'El Password no puede ir vacio';
    //     }
    //     return self::$alertas;

    // }

    // // Validación para cuentas nuevas
    // public function validar_cuenta() {
    //     if(!$this->nombre) {
    //         self::$alertas['error'][] = 'El Nombre es Obligatorio';
    //     }
    //     if(!$this->apellido) {
    //         self::$alertas['error'][] = 'El Apellido es Obligatorio';
    //     }
    //     if(!$this->email) {
    //         self::$alertas['error'][] = 'El Email es Obligatorio';
    //     }
    //     if(!$this->password) {
    //         self::$alertas['error'][] = 'El Password no puede ir vacio';
    //     }
    //     if(strlen($this->password) < 6) {
    //         self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
    //     }
    //     if($this->password !== $this->password2) {
    //         self::$alertas['error'][] = 'Los password son diferentes';
    //     }
    //     return self::$alertas;
    // }

    // // Valida un email
    // public function validarEmail() {
    //     if(!$this->email) {
    //         self::$alertas['error'][] = 'El Email es Obligatorio';
    //     }
    //     if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
    //         self::$alertas['error'][] = 'Email no válido';
    //     }
    //     return self::$alertas;
    // }

    // // Valida el Password 
    // public function validarPassword() {
    //     if(!$this->password) {
    //         self::$alertas['error'][] = 'El Password no puede ir vacio';
    //     }
    //     if(strlen($this->password) < 6) {
    //         self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
    //     }
    //     return self::$alertas;
    // }

    // public function nuevo_password() : array {
    //     if(!$this->password_actual) {
    //         self::$alertas['error'][] = 'El Password Actual no puede ir vacio';
    //     }
    //     if(!$this->password_nuevo) {
    //         self::$alertas['error'][] = 'El Password Nuevo no puede ir vacio';
    //     }
    //     if(strlen($this->password_nuevo) < 6) {
    //         self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
    //     }
    //     return self::$alertas;
    // }

    // // Comprobar el password
    // public function comprobar_password() : bool {
    //     return password_verify($this->password_actual, $this->password );
    // }

    // // Hashea el password
    // public function hashPassword() : void {
    //     $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    // }

    // // Generar un Token
    // public function crearToken() : void {
    //     $this->token = uniqid();
    // }



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

        if(!$this->lastName) {
            self::$alerts['error'][] = 'El apellido es obligatorio';
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s'-]+$/", $this->lastName)) {
            self::$alerts["error"][] = "El apellido solo puede contener letras, espacios, apóstrofes y guiones.";
        } elseif (mb_strlen($this->lastName) > 30) {
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