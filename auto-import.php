<?php
spl_autoload_register(function (string $class){

    $path = __DIR__."/{$class}.php";
    if(is_readable($path)){
        require $path;
        return true;
    }
    var_dump("Файл {$class} не найден!!!");
    return false;
});