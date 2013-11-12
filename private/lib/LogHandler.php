<?php

class LogHandler {

    const DEBUG = 'Debug';
    const INFO = 'Info';
    const WARNING = 'Warning';
    const ERROR = 'Error';
    const FATAL = 'Fatal';

    public static $error_types = array(
        E_DEPRECATED => 'DEPRECATED',
        E_ERROR => 'ERROR',
        E_WARNING => 'WARNING',
        E_PARSE => 'PARSING ERROR',
        E_NOTICE => 'NOTICE',
        E_CORE_ERROR => 'CORE ERROR',
        E_CORE_WARNING => 'CORE WARNING',
        E_COMPILE_ERROR => 'COMPILE ERROR',
        E_COMPILE_WARNING => 'COMPILE WARNING',
        E_USER_DEPRECATED => 'USER DEPRECATED',
        E_USER_ERROR => 'USER ERROR',
        E_USER_WARNING => 'USER WARNING',
        E_USER_NOTICE => 'USER NOTICE',
        E_STRICT => 'STRICT NOTICE',
        E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR'
    );

    public static function log_message($level, $file, $line, $message) {
        $message = date('Y-m-d H:i:s') . "; {$level}; {$file}:{$line}; {$message}\n";
        self::write_in_log($message);
    }

    public static function log_exception(Exception $exc) {
        $file = $exc->getFile();
        $line = $exc->getLine();
        $message = $exc->getMessage();

        $message = date('Y-m-d H:i:s') . "; Exception; {$file}:{$line}; {$message}\n";
        self::write_in_log($message);
    }

    public static function log_php_error($error_number, $message, $file, $line) {
        $error_type = array_key_exists($error_number, self::$error_types) ? self::$error_types[$error_number] : 'UNKNOW';
        $message = date('Y-m-d H:i:s') . "; {$error_type}; {$file}:{$line}; {$message}\n";
        self::write_in_log($message);

        return false; # Continue with PHP internal error handler
    }

    public static function log_fatal_error() {
        $last_error = error_get_last();

        if ($last_error != NULL) {
            $error_code = $last_error['type'];
            $file = $last_error['file'];
            $line = $last_error['line'];
            $message = $last_error['message'];

            if ($error_code === E_ERROR) {
                $error_type = array_key_exists($error_code, self::$error_types) ? self::$error_types[$error_code] : 'UNKNOW';
                $message = date('Y-m-d H:i:s') . "; {$error_type}; {$file}:{$line}; {$message}\n";
                self::write_in_log($message);
            }
        }
    }

    private static function write_in_log($message) {
        $log_filename = self::create_log_file();
        error_log($message, 3, $log_filename);
    }

    private static function create_log_file() {
        $filename = LOG_DIR . '/' . date('Y_m_d') . '.log';
        if (!file_exists($filename)) {
            touch($filename);
            if (!is_writable($filename)) {
                chmod($filename, 0660); # Read and write for owner and group
            }
        }

        return $filename;
    }
}

?>

