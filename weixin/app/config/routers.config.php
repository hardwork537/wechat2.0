<?php
$router = new Phalcon\Mvc\Router();

$router->add('/', array(
    "controller"    => 'home',
    'action'        => 'index' 
));

//导购详情页
$router->add("/roomtype.htm&?(.*)", array(
    "controller"    => 'room',
    'action'        => 'index',
    'name'          => 'tony'
));


$router->notFound(array(
    "controller" => "home",
    "action"     => "index"
));
