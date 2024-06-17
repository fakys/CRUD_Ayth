<?php
namespace vendor\router;

use vendor\traits\create_object;

class Router
{
    use create_object;
    private $urls_get = [];
    private $urls_post = [];

    public static function index(array $controller)
    {
        return self::get_objects()->add_url_get('index', $controller);
    }
    public function post(string $url, array $controller)
    {
        if(count($controller) == 2){
            $method = $controller[1];
            $this->urls_post[$url] = $controller[0]::object()->$method();
        }
    }
    public static function get(string $url, array $controller)
    {

        return self::get_objects()->add_url_get($url, $controller);
    }
    private function add_url_get(string $url, array $controller)
    {
        if(count($controller) == 2){
            $this->urls_get[$url] = $controller;
        }
    }
    private function get_urls_get()
    {

        if(isset($_GET['url']) && isset($this->urls_get[$_GET['url']])){
            $controller =  $this->urls_get[$_GET['url']][0];
            $method = $this->urls_get[$_GET['url']][1];
        }else{
            $controller =  $this->urls_get['index'][0];
            $method = $this->urls_get['index'][1];
        }
        return $controller::object()->$method();
    }
    private function add_urls_post()
    {

        if(isset($this->urls_get[$_POST['url']])){
            $controller =  $this->urls_get[$_POST['url']][0];
            $method = $this->urls_get[$_POST['url']][1];
            return $controller::object()->$method();
        }
        return null;
    }

    public static function start()
    {

        if($_SERVER['REQUEST_METHOD']== 'GET' && isset($_GET['url'])){
            return self::get_objects()->get_urls_get();
        }elseif ($_SERVER['REQUEST_METHOD']== 'POST' && isset($_GET['url'])){
            return self::get_objects()->add_urls_post();
        }else{
            return self::get_objects()->get_urls_get();
        }
    }
}
