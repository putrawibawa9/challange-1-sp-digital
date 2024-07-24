<?php
use Core\Router;

$router = new Router();

$router->get('/', 'Bulletin@viewBulletin');
$router->post('/store', 'Bulletin@store');

return $router;
?>
