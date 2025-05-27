<?php
require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';
require_once '../controllers/BaseBreadTwigController.php';
require_once '../controllers/MainController.php';
require_once '../controllers/Controller404.php';
require_once '../controllers/ObjectController.php';
require_once '../controllers/SearchController.php';
require_once '../controllers/BreadObjectCreateController.php';
require_once '../controllers/BreadVariantCreateController.php';
require_once '../controllers/BreadObjectDeleteController.php';
require_once '../controllers/BreadVariantDeleteController.php';
require_once '../controllers/BaseObjectUpdateController.php';
require_once '../controllers/BreadVariantUpdateController.php';
require_once '../controllers/SetWelcomeController.php';
require_once '../controllers/LoginController.php';
require_once '../controllers/LogoutController.php';
require_once '../middlewares/LoginRequiredMiddleware.php';
require_once '../middlewares/VisitHistoryMiddleware.php';

$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$pdo = new PDO("mysql:host=localhost;dbname=bakery;charset=utf8", "root", "");
$router = new Router($twig, $pdo);

// Public routes (no authentication required)
$router->add("/", MainController::class)
    ->middleware(new VisitHistoryMiddleware());

$router->add("/login", LoginController::class)
    ->middleware(new VisitHistoryMiddleware());

$router->add("/logout", LogoutController::class)
    ->middleware(new VisitHistoryMiddleware());

$router->add("/search", SearchController::class)
    ->middleware(new VisitHistoryMiddleware());

$router->add("/bread-object/(?P<id>\d+)", ObjectController::class)
    ->middleware(new VisitHistoryMiddleware());

$router->add("/404", Controller404::class)
    ->middleware(new VisitHistoryMiddleware());

// Protected routes (require authentication)
$router->add("/bread-object/create", BreadObjectCreateController::class)
    ->middleware(new LoginRequiredMiddleware())
    ->middleware(new VisitHistoryMiddleware());

$router->add("/bread-object/(?P<id>\d+)/edit", BaseObjectUpdateController::class)
    ->middleware(new LoginRequiredMiddleware())
    ->middleware(new VisitHistoryMiddleware());

$router->add("/bread-object/(?P<id>\d+)/delete", BreadObjectDeleteController::class)
    ->middleware(new LoginRequiredMiddleware())
    ->middleware(new VisitHistoryMiddleware());

$router->add("/bread-variants", BreadVariantCreateController::class)
    ->middleware(new LoginRequiredMiddleware())
    ->middleware(new VisitHistoryMiddleware());

$router->add("/bread-variant/(?P<id>\d+)/edit", BreadVariantUpdateController::class)
    ->middleware(new LoginRequiredMiddleware())
    ->middleware(new VisitHistoryMiddleware());

$router->add("/bread-variant/(?P<id>\d+)/delete", BreadVariantDeleteController::class)
    ->middleware(new LoginRequiredMiddleware())
    ->middleware(new VisitHistoryMiddleware());

$router->add("/set-welcome", SetWelcomeController::class)
    ->middleware(new LoginRequiredMiddleware())
    ->middleware(new VisitHistoryMiddleware());

$router->get_or_default(Controller404::class);