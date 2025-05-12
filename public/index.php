<?php
require_once '../vendor/autoload.php';
$controllers = [
    'MainController',
    'WhiteBreadController',
    'WhiteBreadImageController',
    'WhiteBreadInfoController',
    'RyeBreadController',
    'RyeBreadImageController',
    'RyeBreadInfoController',
    'Controller404'
];

foreach ($controllers as $controller) {
    require_once "../controllers/{$controller}.php";
}

$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader);

$url = $_SERVER["REQUEST_URI"];
$title = "";
$url_title = "";
$template = "";
$context = [];

$controller = new Controller404($twig);
if ($url == "/") {
    $controller = new MainController($twig);
}
 elseif (preg_match("#^/white_bread/image#", $url)) {
    $controller = new WhiteBreadImageController($twig);
 } elseif (preg_match("#^/white_bread/info#", $url)) {
     $controller = new WhiteBreadInfoController($twig);
 } elseif (preg_match("#^/white_bread#", $url)) {
     $controller = new WhiteBreadController($twig);
 } 
  elseif (preg_match("#^/rye_bread/image#", $url)) {
    $controller = new RyeBreadImageController($twig);
 } elseif (preg_match("#^/rye_bread/info#", $url)) {
     $controller = new RyeBreadInfoController($twig);
 } elseif (preg_match("#^/rye_bread#", $url)) {
     $controller = new RyeBreadController($twig);
 } 
if ($controller) {
    $controller->get();
}
