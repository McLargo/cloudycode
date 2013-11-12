<?php

function connect_db() {
    try {
        $db = new PDO('mysql:host=' . HOST_DDBB . ';dbname=' . NAME_DDBB, USERNAME_DDBB, PASS_DDBB, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        return $db;
    } catch (PDOException $e) {
        LogHandler::log_message(LogHandler::FATAL, __FILE__, __LINE__, $e->getMessage());
        die();
    }
}

?>
