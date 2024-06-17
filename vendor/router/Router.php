<?php
namespace vendor\router;

use vendor\traits\create_object;

class Router
{
    use create_object;
    private $urls_get = [];

    public static function index(array $controller, string  $name)
    {
        return self::get_objects()->add_url_get('index', $controller, $name);
    }
    public function get_url($name)
    {
        foreach ($this->urls_get as $key=>$value){
            if($name==$value['name']){
                return $value['url'];
            }
        }
    }
    public static function get(string $url, array $controller, string $name)
    {

        return self::get_objects()->add_url_get($url, $controller, $name);
    }
    private function add_url_get(string $url, array $controller, $name)
    {

        if(count($controller) == 2){
            $this->urls_get[$url] = [
                'controller'=>$controller,
                'name'=>$name,
                'url'=>$url
            ];
        }
    }
    private function get_urls_get()
    {
        if(isset($_GET['url']) && isset($this->urls_get[$_GET['url']])){
            $controller =  $this->urls_get[$_GET['url']]['controller'][0];
            $method = $this->urls_get[$_GET['url']]['controller'][1];
        }else{
            $controller =  $this->urls_get['index'][0];
            $method = $this->urls_get['index'][1];
        }
        return $controller::object()->$method();
    }

    public static function start()
    {

        if($_SERVER['REQUEST_METHOD']== 'GET' && isset($_GET['url'])){
            return self::get_objects()->get_urls_get();
        }else{
            return self::get_objects()->get_urls_get();
        }
    }
}
