<?php
namespace core;
use Core\Router;
class App extends Router{
    // Controlling the url and manage it so that we can use it
    public function __construct(){
        $url = Router::parseURL();

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
}
?>
