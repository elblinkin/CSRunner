<?php

function loader($class_name) {
    $class_name = ltrim($class_name, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strripos($class_name, '\\')) {
        $namespace = substr($class_name, 0, $lastNsPos);
        $class_name = substr($class_name, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';

    require $fileName;
}

spl_autoload_register('loader');