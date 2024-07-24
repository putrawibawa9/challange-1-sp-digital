<?php
namespace Core;

class Router {
    protected $routes = [];
    protected $controller = "BulletinController";
    protected $method = "viewBulletin";
    protected $params = [];

    public function get($uri, $controllerMethod) {
        $this->routes['GET'][$uri] = $controllerMethod;
    }

    public function post($uri, $controllerMethod) {
        $this->routes['POST'][$uri] = $controllerMethod;
    }

    public function dispatch() {
        $url = URL::parseURL();
        $parsedUri = isset($url[0]) ? '/' . $url[0] : '/';
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestMethod][$parsedUri])) {
            $controllerMethod = explode('@', $this->routes[$requestMethod][$parsedUri]);
            $this->controller = $controllerMethod[0];
            $this->method = $controllerMethod[1];
        } else {
           require_once "../app/views/error/index.php";
           return;
        }

        require_once "../app/controllers/{$this->controller}.php";
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
?>
