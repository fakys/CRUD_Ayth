<?php
function debug($arg)
{
    $file = debug_backtrace()[0]['file'];
    $line = debug_backtrace()[0]['line'];
    print_r("<p>$file: line $line");

    echo "<pre>";
    var_dump($arg);
    echo "</pre>";
    die();
}
