<?php
require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';
require_once '../controllers/BaseBreadTwigController.php';
require_once '../controllers/MainController.php';
require_once '../controllers/Controller404.php';
require_once '../controllers/ObjectController.php';
require_once '../controllers/SearchController.php';
require_once '../controllers/BreadObjectCreateController.php';
require_once '../controllers/BreadVariantController.php';

$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$pdo = new PDO("mysql:host=localhost;dbname=bakery;charset=utf8", "root", "");
$router = new Router($twig, $pdo);
$router->add("/", MainController::class);

$router->add("/bread-object/(?P<id>\d+)", ObjectController::class);

$router->add("/search", SearchController::class);

$router->add("/bread-object/create", BreadObjectCreateController::class);

$router->add("/bread-variants", BreadVariantController::class);

$router->add("/404", Controller404::class);

$router->get_or_default(Controller404::class);