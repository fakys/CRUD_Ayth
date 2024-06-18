<?php
namespace vendor\database\model\traits;

trait rules
{
    public $messages = [];
    public function rules()
    {
        return [];
    }
    public function labels()
    {
        return [];
    }
    public function check_error()
    {
        if($this->messages){
            return true;
        }
        return false;
    }

    public function validate()
    {
        $this->check_rules($this->rules());
        return !$this->check_error();

    }
    private function check_rules(array $rules)
    {

        foreach ($rules as $key=>$rul){
            foreach ($rul as $key_two=>$val){
                if(!is_int($key_two)){
                    $this->get_rules($key, $key_two,$val);
                }else{
                    $this->get_rules($key, $val);
                }
            }
        }
    }
    public function add_messages($field, $message)
    {
        if(empty($this->messages[$field])){
            $this->messages[$field] = $message;
        }
    }
    private function check_label($field)
    {
        if(isset($this->labels()[$field])){
            return $this->labels()[$field];
        }
        return $field;
    }
    private function rule_email($field)
    {
        if(isset($this->data[$field])){
            if(!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)){
                $field_name = $this->check_label($field);
                $message = "Поле $field_name не является email";
                $this->add_messages($field, $message);
            }
        }
    }
    private function unset_messages($field)
    {
        if($this->has_message($field)){
            unset($this->messages[$field]);
        }
    }
    private function rule_required($field)
    {
        if(empty($this->data[$field])){
            $field_name = $this->check_label($field);
            $message = "Поле $field_name обязательное!!";
            $this->add_messages($field, $message);
        }else{
            $this->unset_messages($field);
        }
    }
    private function rule_unique($field)
    {
        if(isset($this->data[$field])){

            if($this->where([$field=>$this->data[$field]])->one()->id){
                $field_name = $this->check_label($field[0]);
                $message = "Аккаунт с таким $field_name уже есть";
                $this->add_messages($field, $message);
            }
        }
    }
    private function rule_equal($field)
    {

        if(isset($this->data[$field[0]])&&isset($this->data[$field[1]])){
            if($this->data[$field[0]] != $this->data[$field[1]]){
                $field_name_one = $this->check_label($field[0]);
                $field_name_two = $this->check_label($field[1]);
                $message = "Поле $field_name_one и  $field_name_two должны быть равны!!";
                $this->add_messages($field[0], $message);
            }
        }
    }
    private function get_rules(string $field, $rul, $param = [])
    {

        if($rul == 'email'){
            $this->rule_email($field);
        }elseif ($rul == 'required'){
            $this->rule_required($field);
        }elseif ($rul == 'equal'){
            $this->rule_equal([$field,$param]);
        }elseif ($rul == 'unique'){
            $this->rule_unique($field);
        }

    }
    public function errors()
    {
        return $this->messages;
    }
    public function has_message($field)
    {
        if(isset($this->messages[$field])){
            return true;
        }
        return false;
    }
    public function get_message($field)
    {
        if($this->has_message($field)){
            return $this->messages[$field];
        }
        return false;
    }

}