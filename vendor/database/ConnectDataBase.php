<?php

namespace vendor\database;


use PDO;

class ConnectDataBase
{
    public $pdo;
    private $db_data = [];

    public function __construct()
    {
        $this->get_db_data();
    }


    public function __get($key)
    {
        if(isset($this->db_data[$key])){
            return $this->db_data[$key];
        }
        return null;
    }

    private function get_db_data()
    {
        $json = "";
        $file=fopen(dirname(__DIR__, 2) ."/connect_db.json","r") or exit("Невозможно открыть файл!");

        while (!feof($file)) {
            $json .= fgets($file);
        }
        fclose($file);

        $this->as_array(json_decode($json));
    }

    private function as_array($json)
    {
        $this->db_data['db_name'] = $json->data_base;
        $this->db_data['db_host'] = $json->db_host;
        $this->db_data['user_name'] = $json->user_name;
        $this->db_data['password'] = $json->password;
        $this->db_data['encoding'] = $json->encoding;
    }
    public static  function objects()
    {
        $class_name= get_class();
        return new $class_name();
    }
    public function db_connect()
    {
        if(!$this->pdo)
        $this->pdo = new PDO("mysql:dbname={$this->db_data['db_name']};host={$this->db_data['db_host']};charset={$this->db_data['encoding']}",
            $this->db_data['user_name'],
            $this->db_data['password']
        );
        return $this;
    }
}