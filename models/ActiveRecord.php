<?php
    namespace Model;
    use PDO;

    /**
     * Clase base ActiveRecord
     * 
     * @property int|null $id
     * @property string|null $imagen
     * @property string|null $creado
     * @property int $estado
    */

    interface ActiveRecordInterface {
        public function validate(): array;
        public function save(): bool;
        public function update(): bool;
        public function create(): bool;
        public function delete(): bool;
        public function sincronize(array $args): void;
        public function cleanAtributes(): array;
    }

    abstract class ActiveRecord implements ActiveRecordInterface {
    
        // Propiedad para la conexión
        protected static $db;
        
        // Mapeo de columnas
        protected static $columnsDB = [];
        protected static $table = "";

        // Alertas y Mensajes
        protected static $alerts = [];

        // Método estático para asignar la conexión 
        public static function setDB($database): void {
            self::$db = $database;
        }

        public static function setAlert(string $type, string $message): void {
            static::$alerts[$type][] = $message;
        }

        // Obtener las alertas
        public static function getAlerts(): array {
            return static::$alerts;
        }

        // Stub vacío de validate()
        public function validate(): array {
            return [];
        }

        // Paginar los registros
        // public static function paginate($per_page, $offset) {
        //     $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC LIMIT {$per_page} OFFSET {$offset}";
        //     $result = self::consultSQL($query);
        //     return $result;
        // }

        public static function paginate($per_page, $offset) {
        // Verificar si esta clase tiene relaciones definidas
        if(!empty(static::$relations)) {
            // Si tiene relaciones, construir query con JOINs
            $fields = static::relationsFields(); // Trae los campos que definiste
            $joins = static::buildRelations();    // Construye los LEFT JOIN
            
            $query = "
                SELECT $fields
                FROM " . static::$table . "
                $joins
                ORDER BY " . static::$table . ".id DESC 
                LIMIT {$per_page} OFFSET {$offset}
            ";
        } else {
            // Si no tiene relaciones, query normal
            $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC LIMIT {$per_page} OFFSET {$offset}";
        }
        
        $result = self::consultSQL($query);
        return $result;
        }

        
        // Traer un total de los registros
        public static function total($column = "", $value = "") {
            $query = "SELECT COUNT(*) FROM " . static::$table;

            if($column) {
                $query .= " WHERE {$column} = {$value}";
            }

            $result = self::$db->query($query);
            $total = $result->fetch(PDO::FETCH_ASSOC);
            return array_shift($total);
        }


        // Traer un total de los registros con un Array Where
        public static function totalArray($array = []) {
            $query = "SELECT COUNT(*) FROM " . static::$table  . " WHERE ";

            foreach($array as $key => $value) {
                if($key == array_key_last($array)) {
                    $query .= "{$key} = '{$value}'";
                } else {
                    $query .= "{$key} = '{$value}' AND ";
                }
            }

            $result = self::$db->query($query);
            $total = $result->fetch(PDO::FETCH_ASSOC);
            return array_shift($total);
        }


        /**
         * Devuelve los campos que se deben seleccionar en la consulta.
         * Si hay relaciones definidas, incluye los alias (AS). Si no, solo '*'.
         */
        protected static function relationsFields(): string {
            $extra = static::$relationsFields ?? [];
            return empty($extra)
                ? static::$table . ".*"
                : static::$table . ".*, " . implode(", ", $extra);
        }


        /**
         * Devuelve los JOINs definidos por el modelo hijo (si existen).
         */
        protected static function buildRelations(): string {
            $joins = static::$relations ?? [];
            return implode(" ", $joins);
        }


        protected static function createObject($registro): static {
            $objeto = new static;
            foreach ($registro as $key => $value) {
                if(property_exists($objeto, $key)) {
                    $objeto->$key = $value;
                } else {
                    $objeto->$key = $value; // Asignar dinámicamente propiedades no definidas (relaciones)
                }
            }
            return $objeto;
        }

        /**
         * Trae todos los registros con o sin relaciones.
         * Puede ordenar por una columna y limitar la cantidad de resultados.
         *
         * @param string $orderBy - Columna por la que ordenar (por defecto 'id')
         * @param int|null $limit - Límite de resultados
         * @param bool $desc - Si se debe ordenar en descendente (true) o ascendente (false)
         */
        public static function allWithJoins($orderBy = "id", $limit = null, $desc = true): array {
            $fields = static::relationsFields();
            $joins = static::buildRelations();

            $query = "
                SELECT $fields
                FROM " . static::$table . "
                $joins
                ORDER BY " . static::$table . ".$orderBy " . ($desc ? "DESC" : "ASC");

            if($limit) {
                $query .= " LIMIT " . intval($limit);
            }
            return self::consultSQL($query);
        }


        /**
         * Trae un sólo registro que coincida con el id que se pasa.
         * @param int $id - El id que se pasa para la búsqueda
         */
        public static function find(int $id): static|null {
            $fields = static::relationsFields();
            $joins = static::buildRelations();

            $query = "
                SELECT $fields
                FROM " . static::$table . "
                $joins
                WHERE " . static::$table . ".id = :id
                LIMIT 1
            ";

            $stmt = self::$db->prepare($query);
            $stmt->execute(['id' => $id]);

            $registro = $stmt->fetch(PDO::FETCH_ASSOC);
            return $registro ? static::createObject($registro) : null;
        }


        /**
         * 
         */
        public static function where(string $column, mixed $value): static|null {
            $fields = static::relationsFields();
            $joins = static::buildRelations();

            $query = "
                SELECT $fields
                FROM " . static::$table . "
                $joins
                WHERE $column = :value
                LIMIT 1
            ";

            $stmt = self::$db->prepare($query);
            $stmt->execute(['value' => $value]);

            $registro = $stmt->fetch(PDO::FETCH_ASSOC);
            return $registro ? static::createObject($registro) : null;
        }


        public static function whereAll(string $column, mixed $value): array {
            $fields = static::relationsFields();
            $joins = static::buildRelations();

            $query = "
                SELECT $fields
                FROM " . static::$table . "
                $joins
                WHERE $column = :value
            ";

            $stmt = self::$db->prepare($query);
            $stmt->execute(['value' => $value]);

            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $objetos = [];

            foreach ($registros as $registro) {
                $objetos[] = static::createObject($registro);
            }

            return $objetos;
        }


        /** Búsqueda where con multiples opciones
         * 
         */
        public static function whereArray($array = []) {
            $query = "SELECT * FROM " . static::$table . " WHERE ";
            foreach($array as $key => $value) {
                if($key == array_key_last($array)) {
                    $query .= "{$key} = '{$value}'";
                } else {
                    $query .= "{$key} = '{$value}' AND ";
                }
            }
            $result = self::consultSQL($query);
            return $result;
        }


        public function save(): bool {
            if(!is_null($this->id)) { // Si ya hay un Id
                return $this->update(); // Actualizar
            } else {
                return $this->create(); // Crear nuevo registro
            }
        }


        public function update(): bool {
            $atributes = $this->cleanAtributes();
        
            $values = [];
            foreach (array_keys($atributes) as $key) {
                $values[] = "$key = :$key";
            }
        
            $query = "UPDATE " . static::$table . " SET ";
            $query .= implode(', ', $values);
            $query .= " WHERE id = :id LIMIT 1";
        
            $atributes['id'] = $this->id;
            $stmt = self::$db->prepare($query);
            $result = $stmt->execute($atributes);
        
            if (!$result) {
                error_log("ERROR EN ACTUALIZAR: " . print_r($stmt->errorInfo(), true));
            }
            return $result;
        }


        public function create(): bool {
            $atributes = $this->cleanAtributes();
            $columns = array_keys($atributes);
            $placeholders = array_map(fn($col) => ":$col", $columns); // Los : se llaman placeholders

            // Armamos la consulta
            $query = "INSERT INTO " . static::$table . " (" . implode(', ', $columns) . ")";
            $query .= " VALUES (" . implode(', ', $placeholders) . ")";
        
            $stmt = self::$db->prepare($query); // Preparamos la consulta
            $result = $stmt->execute($atributes); // Ejecutamos

            if (!$result) {
                error_log("ERROR EN CREAR: " . print_r($stmt->errorInfo(), true));
                return false;
            }

            $this->id = self::$db->lastInsertId(); // Actualiza la propiedad `id` del objeto
            return true;
        }

        
        // Sincroniza el objeto en memoria con los cambios realizados por el usuario
        // public function sincronize($args = []): void {
        //     // foreach($args as $key => $value) {
        //     //     if(property_exists($this, $key) && !is_null($value)) {
        //     //         $this->$key = is_string($value) ? trim($value) : $value;
        //     //     }
        //     // }

        //     // Definir qué propiedades deben ser convertidas a entero
        //     $integerProperties = ['available', 'category_id', 'day_id', 'hour_id', 'speaker_id'];
            
        //     foreach($args as $key => $value) {
        //         if(property_exists($this, $key) && !is_null($value)) {
                    
        //             // Si la propiedad debe ser un entero
        //             if(in_array($key, $integerProperties)) {
        //                 // Convertir string vacío a null para propiedades nullable
        //                 if(is_string($value) && trim($value) === '') {
        //                     $this->$key = null;
        //                 } else {
        //                     // Convertir a entero
        //                     $this->$key = (int)$value;
        //                 }
        //             } else {
        //                 // Para propiedades string, aplicar trim como antes
        //                 $this->$key = is_string($value) ? trim($value) : $value;
        //             }
        //         }
        //     }
        // }

        
        public function sincronize($args = []): void {
            foreach($args as $key => $value) {
                if(property_exists($this, $key) && !is_null($value)) {
                    
                    // Obtener el tipo de la propiedad usando reflexión
                    $reflection = new \ReflectionProperty($this, $key);
                    $type = $reflection->getType();
                    
                    if($type && !$type->isBuiltin()) {
                        continue; // Saltar propiedades de objeto
                    }
                    
                    if($type && $type->getName() === 'int') {
                        // Manejar conversión a entero
                        if(is_string($value) && trim($value) === '' && $type->allowsNull()) {
                            $this->$key = null;
                        } else {
                            $this->$key = (int)$value;
                        }
                    } else {
                        // Para otros tipos (especialmente string)
                        $this->$key = is_string($value) ? trim($value) : $value;
                    }
                }
            }
        }

        
        // Eliminar un registro
        public function delete(): bool {
            $query = "DELETE FROM " . static::$table . " WHERE id = :id LIMIT 1";
            $stmt = self::$db->prepare($query);
            $result = $stmt->execute(['id' => $this->id]);
            return $result;
        }


        // Limpia los atributos
        public function cleanAtributes(): array {
            $atributes = [];
            foreach (static::$columnsDB as $column) {
                if(in_array($column, ['id', 'creado', 'fecha_registro'])) continue;
                $atributes[$column] = $this->$column;
            }
            return $atributes;
        }

        
        public static function consultSQL($query): array {
            // Consultar la base de datos
            $stmt = self::$db->query($query);

            // Iterar los resultados
            $array = [];
            while($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $array[] = static::createObject($registro);
            }
            // Retornar los resultados
            return $array;
        }
    }