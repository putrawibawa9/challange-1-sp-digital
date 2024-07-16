<?php

class Flasher{
    public static function setFlash($msg, $action, $type){
        $_SESSION['flash'] = [
            'msg' => $msg,
            'action' => $action,
            'type' => $type
        ];

    }

    public static function flash(){
        if(isset($_SESSION['flash'])){
            echo '<div ' . ' alert-dismissible fade show" role="alert">
             <strong>' . $_SESSION['flash']['msg'] . '</strong> ' . $_SESSION['flash']['action'] . '
            </div>';
            unset($_SESSION['flash']);
        }
    }
}