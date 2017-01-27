<?php
spl_autoload_register(function($class) {
    $parts = explode('\\', $class);
    if(!$parts || $parts[0] != 'Cranespud') {
        return;
    }

    echo "$class \n";
    $file = join('/', $parts) . '.php';
    require(__DIR__ . DIRECTORY_SEPARATOR . $file);

});