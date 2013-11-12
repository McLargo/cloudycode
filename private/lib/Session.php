<?php


class Session{

    static $prefix = "cc_";

    public static function set_value($name, $value) {
        $_SESSION[self::$prefix . $name] = $value;
    }

    public static function get_value($name, $default = '') {
        return isset($_SESSION[self::$prefix . $name]) ? $_SESSION[self::$prefix . $name] : $default;
    }

    public static function delete_all_data() {
        foreach ($_SESSION as $index => $value) {
            if (stripos($index, self::$prefix) !== false) {
                unset($_SESSION[$index]);
            }
        }
    }

}
?>
