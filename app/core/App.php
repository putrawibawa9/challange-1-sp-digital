<?php
class App{
    // initiate the variable for each and set the default for each functionality
    protected $controller = "bulletin";
    protected $method = "viewBulletin";
    protected $params = [];

    // Controlling the url and manage it so that we can use it
    public function __construct(){
        $url = $this->parseURL();

        // Get Controller Name
        if($url !== null && isset($url[0]) && file_exists('../app/controllers/' . $url[0] . '.php')){
            $this->controller = $url[0];
            unset($url[0]);
        }

        // Get Method Name
        require_once "../app/controllers/$this->controller.php";
        $this->controller = new $this->controller;

        if(isset($url[1])){
            if(method_exists($this->controller,$url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Get the params
        if(!empty($url)){
            $this->params = array_values($url);
        }

        // Running the controller, its method, and the params if available
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    // Getting the url and sanitize it so that we can use it as controller, method, and params
    public function parseURL(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);    
            return $url;
        }
    }
}