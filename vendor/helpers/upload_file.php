<?php
function upload_file($file, $to)
{
    $name = uniqid().$file['name'];
    $main = dirname(__DIR__, 2) . "/assets/$to/$name";
    move_uploaded_file($file['tmp_name'], $main);
    return $name;
}