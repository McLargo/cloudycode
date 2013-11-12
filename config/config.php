<?php

# config.php
#  define constante dev_enviroment in case we have one ddbb for dev and one with the right data
#  define cost such as path, mails...

        const DEV_ENVIROMENT = true;

if (DEV_ENVIROMENT) {
    define('HOST_DDBB', 'localhost');
    define('USERNAME_DDBB', 'javier');
    define('PASS_DDBB', '**');
    define('NAME_DDBB', 'ajax');
} else {
    define('HOST_DDBB', 'localhost');
    define('USERNAME_DDBB', 'javier');
    define('PASS_DDBB', '**');
    define('NAME_DDBB', 'ajax');
}

/*
define('EMAIL_HOST', '');
define('EMAIL_PORT', );
define('EMAIL_USER', '');
define('EMAIL_PASS', );
define('EMAIL_IS_TLS', true);
define('EMAIL_IS_SSL', false);
define('EMAIL_SENDER_ADDRESS', '');
define('EMAIL_SENDER_NAME', '');
*/


define ('LOG_APP', '/');
define('LOG_DIR', LOG_APP.'assets/log');

set_error_handler(array('LogHandler', 'log_php_error'));
set_exception_handler(array('LogHandler', 'log_exception'));
register_shutdown_function(array('LogHandler', 'log_fatal_error'));
?>
