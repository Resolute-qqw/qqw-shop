<?php
// 时区
date_default_timezone_set('PRC');
session_start();

define("ROOT",__DIR__."/../");
require ROOT."libs/function.php";

function load($class){
    $path = str_replace('\\','/',$class);
    require ROOT.$path.".php";
}

spl_autoload_register('load');

$controller = "\controllers\IndexController";
$action = "index";

if(isset($_SERVER['PATH_INFO'])){
    $route = explode("/",$_SERVER['PATH_INFO']);
    $controller = "controllers\\".ucfirst($route[1])."Controller";
    $action = $route[2];
}

$con = new $controller;
$con->$action();

