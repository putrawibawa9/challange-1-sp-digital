<?php
namespace core;
class URL{
        // initiate the variable for each and set the default for each functionality
public static function parseURL(){
    if(isset($_GET['url'])){
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
    }
}
}

?>
