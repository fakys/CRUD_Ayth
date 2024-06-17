<?php
namespace vendor\database\model;


use vendor\database\ConnectDataBase;
use PDO;
use vendor\string\StringSql;
use vendor\traits\create_object;

class Model
{
    use create_object;
    protected $db;
    protected static $table_name;
    private array $data;
    private $prepare;
    protected $pk;
    protected array $fields = [];
    private $sql;

    public function __construct(array $data = [])
    {
        $this->db = ConnectDataBase::objects()->db_connect();
        $this->data = $data;
    }

    public function __get($field)
    {
        if(isset($this->data[$field])) return $this->data[$field];
        return null;
    }
    public function __set($field, $value){
        $this->data[$field] = $value;
    }

    public function get_table_name()
    {
        if(self::get_objects()::$table_name){
            return self::get_objects()::$table_name;
        }else{
            return get_called_class();
        }
    }

    protected function queryAll( string $sql, array $field = [])
    {
        $query = $this->db->pdo->prepare($sql);
        if($field){
            $query->execute($field);
            return $query->fetchAll();
        }
        $query->execute();
        return $query->fetchAll();
    }









    public function fill_data($data)
    {
        $this->data = $data;
        return $this;
    }
    private function add_data($data)
    {
        $class_name = get_called_class();
        $obj = new $class_name;
        return $obj->fill_data($data);
    }
    private function clear_sql()
    {
        return $this->get_sql()->clear_sql();
    }
    private function model_sql()
    {
        return StringSql::object(self::get_table_name());
    }
    private function get_sql()
    {
        if($this->sql){
            return $this->sql;
        }
        $this->sql = $this->model_sql();
        return $this->sql;
    }
    private function set_sql(StringSql $model){
        $this->sql = $model;
    }

    public function where(array $arr)
    {
        $this->set_sql($this->get_sql()->where($arr));
        $this->query();
        return $this;
    }

    private function create_models($fetch)
    {
        $arr_model = [];
        foreach ($fetch as $val){
            $arr_model[] = $this->add_data($val);
        }
        return $arr_model;
    }
    public function one()
    {
        if($this->prepare){
            $data = $this->prepare->fetch(PDO::FETCH_ASSOC);
            if(!$data){
                $data = [];
            }
            return $this->add_data($data);
        }
        return [];
    }
    public function get()
    {
        if($this->prepare){
            return $this->create_models($this->prepare->fetchAll(PDO::FETCH_ASSOC));
        }
        return [];
    }
    private function query()
    {
        $pdo = $this->db->pdo->prepare($this->get_sql()->get());
        $this->add_bind_param($pdo);
        $this->prepare = $pdo;
        $this->prepare->execute();
        $this->clear_sql();
    }

    private function add_bind_param($pdo)
    {
        $value = $this->get_sql()->get_value();
        if($value){
            for($i=0;$i<=count($value)-1;$i++){
                $pdo->bindParam($i+1, $value[$i]);

            }
        }
    }
    private function get_all($field)
    {
        $this->set_sql($this->get_sql()->all($field));
        $this->query();
        return $this->get();
    }

    private function add_fields($field)
    {
        $this->set_sql($this->get_sql()->field($field));
        return $this;
    }

    private function last_create_element()
    {
        return $this->db->pdo->lastInsertId();
    }

    private function get_element_by_pk($pk)
    {
        $this->set_sql($this->get_sql()->pk([$this->get_name_pk()=>$pk]));

        $this->query();
        return $this->one();
    }

    public static function select($field = [])
    {
        return self::get_objects()->add_fields($field);
    }


    private function get_name_pk()
    {
        if($this->pk){
            return $this->pk;
        }
        return 'id';
    }
    private function get_pk()
    {
        if(isset($this->data[$this->get_name_pk()])){
            return $this->data[$this->get_name_pk()];
        }
        return null;
    }

    private function create_object($value)
    {
        $this->get_sql()->create($value);
        $this->query();
        $this->clear_sql();
        return $this->get_element_by_pk($this->last_create_element());
    }
    private function update_object($set, $where)
    {
        if(!$where){
            $where = [$this->get_name_pk()=>$this->get_pk()];
        }
        $this->set_sql($this->get_sql()->update($set, $where));
        $this->query();
        $this->where($where);
        return $this;

    }
    private function delete_element($where)
    {
        if(!$where){
            $where = [$this->get_name_pk()=>$this->get_pk()];
        }
        $this->set_sql($this->get_sql()->delete($where));
        $this->query();
    }

    public static function create(array $value)
    {

        return self::get_objects()->create_object($value);
    }
    public static function update(array $set, array $where = [])
    {
        return self::get_objects()->update_object($set, $where);
    }
    public static function all($field = [])
    {
        return self::get_objects()->get_all($field);
    }
    public static function pk($pk)
    {
        return self::get_objects()->get_element_by_pk($pk);
    }
    public function save()
    {
        if(self::check_object()){
            return self::update($this->data)->one();
        }else{
            if($this->data){
                return self::create($this->data);
            }
            return $this;
        }
    }
    public static function delete($where = [])
    {
        return self::get_objects()->delete_element($where);
    }
}