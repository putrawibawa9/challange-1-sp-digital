<?php
if(!session_id()) session_start();
require_once '../app/init.php';
$router = require_once '../app/core/Routes.php';
// use Core\App;
$router->dispatch();