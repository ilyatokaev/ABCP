<?php

spl_autoload_register(function ($class) {

    $classNameArray = explode('\\', $class);
    $fullClassName = __DIR__ . '/';

    foreach ($classNameArray as $item) {
        $fullClassName .= '/' . $item;
    }

    $fullClassName .= '.php';

    require_once $fullClassName;

});
