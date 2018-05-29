<?php

class DatabaseObject {

    protected static $table_name;

    public static function find_all() {
        return static::find_by_sql("SELECT * FROM " . static::$table_name);
    }

    public static function find_by_sql($sql = "") {
        global $db;
        $result_set = $db->query($sql);
        $object_array = array();
        while ($row = $db->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }

    private static function instantiate($record) {
        $class_name = get_called_class();
        $object = new $class_name;
        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    private function has_attribute($attribute) {
        return array_key_exists($attribute, $this->attributes());
    }

    protected function attributes() {
        $attributes = array();
        foreach (static::$db_fields as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    public static function find_by_id($id = 0) {
        $result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_views() {
        global $db;

        $sql = "SELECT * FROM " . static::$table_name;
        $sql .= " ORDER by id ASC";
        $result = $db->query($sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            $object_array = array();
            while ($row = $db->fetch_array($result)) {
                $object_array[] = static::instantiate($row);
            }
            return $object_array;
        } else {
            return false;
        }
    }

    public static function find_by_ordine() {
        global $db;

        $sql = "SELECT * FROM " . static::$table_name;
        $sql .= " ORDER by id DESC";
        $result = $db->query($sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            $object_array = array();
            while ($row = $db->fetch_array($result)) {
                $object_array[] = static::instantiate($row);
            }
            return $object_array;
        } else {
            return false;
        }
    }

    public static function find_by_ids() {
        global $db;

        $sql = "SELECT * FROM " . static::$table_name;
        $sql .= " ORDER by id ASC";
        $result = $db->query($sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            $object_array = array();
            while ($row = $db->fetch_array($result)) {
                $object_array[] = static::instantiate($row);
            }
            return $object_array;
        } else {
            return false;
        }
    }

    public static function check_if_exists($key = "", $value = "") {
        global $db;
        $key = $db->escape_value($key);
        $value = $db->escape_value($value);
        $sql = "SELECT * FROM " . static::$table_name;
        $sql .= " WHERE {$key} = '{$value}'";
        $result = $db->query($sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function create() {
        global $db;
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";

        if ($db->query($sql)) {
            $this->id = $db->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function insert($sql) {
        global $db;
        $db->query($sql);
    }


    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function delete() {
        global $db;        
        $sql = "DELETE FROM " . static::$table_name;
        $sql .= " LIMIT 1";
        $db->query($sql);
        return ($db->affected_rows() == 1) ? true : false;

        
    }

    protected function sanitized_attributes() {
        global $db;
        $clean_attributes = array();
      
        foreach ($this->attributes() as $key => $value) {
            $clean_attributes[$key] = $db->escape_value($value);
        }
        return $clean_attributes;
    }

    public function redirect_to($location = NULL) {
        if ($location != NULL) {
            header("Location: {$location}");
            exit;
        }
    }

    public function message($message = "") {
        if (!empty($message)) {
            return "<p class=\"message\">{$message}</p>";
        } else {

            return "";
        }
    }

    public static function service_providers($user_id = "") {
        return static::find_by_sql("SELECT * FROM 5m9pw_users WHERE id in (SELECT id_accountant FROM 5m9pw_client_accountant_asoc WHERE id_client = {$user_id})");
    }

    public static function query_sql($sql = "") {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $array = new stdClass();
            foreach ($row as $key => $val) {
                if (!is_int($key)) {
                    $array->$key = $database->escape_value($val);
                }
            }
            $object_array[] = $array;
        }
        return $object_array;
    }

    public static function update_row($table, $keys, $values) {
        global $database;
        $sql = "UPDATE " . $table . " SET ";
        $error = true;
        if (count($keys) == count($values)) {
            foreach ($keys as $k => $key) {
                $sql .= "`$key` = '" . $database->escape_value($values[$k]) . "'";
            }
        } else {
            $error = 'The arrays doesn\'t have the same number of values';
        }
        return $error;
    }

}

?>