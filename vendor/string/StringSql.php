<?php
namespace vendor\string;
use vendor\string\traits\Symbols;

require __DIR__ . '/traits/Symbols.php';

class StringSql
{
    use Symbols;

    private $sql = '';
    private $value=[];
    private static $object;
    private string $table_name;


    public function __construct(string $table_name = '')
    {
        $this->table_name = $table_name;
    }

    public static function object($table_name = '')
    {
        if(!self::$object){
            $class = get_class();
            self::$object = new $class($table_name);
        }
        return self::$object;
    }

    public function clear_sql()
    {
        $this->sql = '';
        $this->value = [];
    }
    public function get()
    {
        return $this->sql;
    }

    public function get_value()
    {
        return $this->value;
    }

    private function simple_array_where($where){
        $sql = '';
        foreach ($where as $key=>$value){
            if(is_string($key)){
                $this->value[]=$value;
                $sql .= "$key = ?";
            }
        }
        return $sql;
    }
    private function difficult_array_where($arr_where)
    {
        $sql = "";
        for ($i=0;$i<=count($arr_where)-1; $i++){
            if($this->check_math_symbols($arr_where[$i])){
                $this->value[]=$arr_where[$i+1];
                $arr_where[$i+1] = "?";
                $sql .="$arr_where[$i] ";
            }else{
                $sql .="$arr_where[$i] ";
            }
        }
        return $sql;
    }
    private function create_sql_where(bool $spec_symbols, array $arr_where)
    {
        if($spec_symbols){
            return implode(' ', $arr_where);
        }else{
            return implode(' AND ', $arr_where);
        }
    }


    private function create_where($arr_where)
    {
        $array_sql = [];
        $spec_symbols = false;
        foreach ($arr_where as $val){
            if(is_array($val) && count($val)== 1){
                $array_sql[] = $this->simple_array_where($val);
            }elseif ($this->check_spec_symbols($val)){
                $spec_symbols = true;
                $array_sql[] = $val;
            }elseif (is_array($val) && count($val)>1){
                $array_sql[] = $this->difficult_array_where($val);
            }
        }
        return $this->create_sql_where($spec_symbols, $array_sql);
    }
    private function check_where($where)
    {
        if(count($where)==1){
            return $this->simple_array_where($where);
        }else{
            foreach ($where as $value){
                if($this->check_math_symbols($value)){
                    return $this->difficult_array_where($where);
                }
            }
            return $this->create_where($where);
        }

    }
    private function string_where(array $where)
    {

        $sql_where = $this->check_where($where);
        if($this->sql){
            $this->sql .=" WHERE ".$sql_where ;
        }else{
            $this->sql = "SELECT * FROM {$this->table_name} WHERE " . $sql_where;
        }
        return $this;
    }

    public function all($field = [])
    {
        if($field){
            $fields = implode(', ', $field);
            $this->sql = "SELECT $fields FROM $this->table_name";
            return $this;
        }
        $this->sql = "SELECT * FROM $this->table_name";
        return $this;
    }

    private function string_field(array $fields)
    {
        if(!$this->sql){
            $fields_str = implode(", ", $fields);
            $this->sql = "SELECT {$fields_str} FROM {$this->table_name}";
        }else{
                $this->sql =str_replace('*', implode(", ", $fields), $this->sql);
        }
        return $this;
    }
    private function string_create($value)
    {
        $meaning = [];
        $fields = [];
        foreach ($value as $key=>$val){
            $meaning[] = '? ';
            $this->value[] = $val;
            $fields[] = $key;
        }
        $meaning = implode(', ', $meaning);
        $fields = implode(', ', $fields);
        $this->sql = "INSERT INTO $this->table_name($fields) VALUES ($meaning)";
        return $this;
    }

    private function string_set(array $set)
    {
        $arr_set = [];
        foreach ($set as $key=>$val){
            $arr_set[] ="$key = ?";
            $this->value[] = $val;
        }
        return implode(', ', $arr_set);
    }
    private function string_update(array $set, array $where){
        $this->sql = "UPDATE $this->table_name SET {$this->string_set($set)}";
        self::where($where);
        return $this;
    }
    private function string_pk($where)
    {
        if(count($where)==1){
            foreach ($where as $key=>$value){
                $this->sql = "SELECT * FROM {$this->table_name} WHERE {$key} = ? LIMIT 1";
                $this->value[] = $value;
            }
        }
        return $this;
    }

    public function string_delete($where)
    {
        $this->sql = "DELETE FROM `users`";
        self::where($where);
        return $this;
    }

    public static function field(array $fields, string $table_name= "")
    {
        return self::object($table_name)->string_field($fields);
    }
    public static function where(array $where, string $table_name = "")
    {
        return self::object($table_name)->string_where($where);
    }
    public static function create(array $value, string $table_name = "")
    {
        return self::object($table_name)->string_create($value);
    }
    public function update(array $set, array $where , string $table_name = ""){
        return self::object($table_name)->string_update($set, $where);
    }
    public function pk(array $where, string $table_name = "")
    {
        return self::object($table_name)->string_pk($where);
    }
    public function delete($where , string $table_name = "")
    {
        return self::object($table_name)->string_delete($where);
    }
}