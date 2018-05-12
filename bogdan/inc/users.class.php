<?php

class users extends DatabaseObject {

    protected static $table = 'users';
    protected static $fields = array('id', 'username', 'email', 'parola');
    public $id;
    public $username;
    public $parola;
    public $email;

    public static function login($username, $parola) {
        global $db;
        $sql = "SELECT * FROM " . static::$table . " WHERE username = '" . $db->escape_value($username) . "' AND parola = '" . ($parola) . "'";
        $result = $db->query($sql);

        $c = $result->fetch_object();
        if ($c) {
            return $c;
        } else {
            return FALSE;
        }
    }

    public static function get_by_id($id) {
        global $db;
        $sql = "SELECT * FROM " . static::$table . " WHERE id = '" . $db->escape_value($id) . "'";
        $result = $db->query($sql);
        $c = $result->fetch_object();
        if ($c) {
            return $c;
        } else {
            return FALSE;
        }
    }

    public function get_user() {
        global $db;
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];

            $sql = "SELECT * FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
            $result = $db->query($sql);

            $c = $result->fetch_object();
            if ($c) {
                $this->logged_in = true;
                return $c;
            } else {
                unset($this->user_id);
                unset($_SESSION['user_id']);
                $this->logged_in = false;
                return FALSE;
            }
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }

}
