<?php

session_start();
require_once '../lib/SessionData.php';

$is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

if (SessionData::get_value('LOGGED', 0) != 1) {
    if ($is_ajax) {
        header('HTTP/1.0 401 Unauthorized');
    } else {
        header('Location: index.php');
    }
    die();
} else {
    $now = time();
    if (($now - SessionData::get_value('LAST_SESSION_REGENERATION', 0)) > 1200) {
        if (session_regenerate_id()) {
            SessionData::set_value('LAST_SESSION_REGENERATION', $now);
        }
    }
}
?>