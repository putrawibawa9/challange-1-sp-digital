<?php
// This is the main controller for being parent for the controllers in controllers folders
class Controller {
    // Displaying the presentation layouts
    public function view($view, $data = []){
        require_once "../app/views/$view.php";
    }

    public function repository($repository){
          require_once "../app/repositories/$repository.php";
          return new $repository;
    }
}