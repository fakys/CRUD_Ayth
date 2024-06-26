<?php
namespace vendor\controller;

use vendor\router\Router;
use vendor\traits\create_object;

class Controller
{
    use create_object;
    protected $layout;
    protected $view;
    private $property = [];
    public function __get($prop)
    {
        if(isset($this->property[$prop])){
            return $this->property[$prop];
        }
        return null;
    }
    protected function check_file($path)
    {
        if(is_readable($path)){
            return true;
        }else{
            return false;
        }
    }
    protected function load_layout()
    {
        if($this->layout){
            $path = "view/".$this->layout.'.php';
            if($this->check_file($path)){
                require $path;
                return true;
            }
        }
        return false;
    }
    protected function content()
    {
        $this->load_content();
    }
    private function load_content()
    {
        $path = "view/".$this->view.'.php';
        if($this->check_file($path)){
            require $path;
            return true;
        }
        return false;
    }
    private function register_props(array $prop)
    {
        $this->property = $prop;
    }
    protected function render(string $view, array $prop = [])
    {

        $this->register_props($prop);
        $this->view = $view;
        if($this->load_layout()){
            return true;
        }
        return $this->load_content();
    }
    public function asset($path)
    {
        $asset = "../../assets/$path";
        return $asset;
    }
    public function route($name, array $get=[])
    {
        $url = Router::object()->get_url($name);
        $locate = "index.php?url=$url";
        if($get){
            $locate = $this->add_gets($locate, $get);
        }
        return $locate;
    }

    private function add_gets($locate, $get)
    {
        foreach ($get as $key=>$val){
            $locate .= "&&$key=$val";
        }
        return $locate;
    }
    public function redirect(string $name, array $get=[])
    {
        $url = Router::object()->get_url($name);
        $locate = "Location: index.php?url=$url";
        if($get){
            $locate = $this->add_gets($locate, $get);
        }
        header($locate);
        die();
    }
}