<?php
use Core\Controller;

class Error extends Controller{
    public function error404(){
         $this->view('error/index',);
    }
}