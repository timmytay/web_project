<?php
require_once '../vendor/autoload.php';
require_once '../controllers/MainController.php';
require_once '../controllers/WhiteBreadController.php';
require_once '../controllers/WhiteBreadImageController.php';
require_once '../controllers/WhiteBreadInfoController.php';
require_once '../controllers/RyeBreadController.php';
require_once '../controllers/RyeBreadImageController.php';
require_once '../controllers/RyeBreadInfoController.php';
require_once "../controllers/Controller404.php";

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
