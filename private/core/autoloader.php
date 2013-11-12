<?php


function f_autoload($class_name) {
    $directories_list = array('include', 'private', 'private/lib');
   
    foreach ($directories_list as $directory) {
        $current_dir = dirname(__FILE__);

       // $file_path = $current_dir . '/../' . $directory . '/' . $class_name . '.php';
        $file_path = $directory . '/' . $class_name . '.php';
        if (file_exists($file_path)) {
            require_once $file_path;
            break;
        }
    }
}

spl_autoload_register('f_autoload');
?>
