<?php
require_once '../vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader);

$url = $_SERVER["REQUEST_URI"];
$title = "";
$url_title = "";
$template = "";
$context = [];
if ($url == "/") {
    $template = "main.twig";
    $title = "Главная";
$context['menu_items' ] = [
    [
        "title" => "Белый хлеб",
        "url_title" => "white_bread",
    ],
    [
        "title" => "Ржаной хлеб",
        "url_title" => "rye_bread",
    ],
];

} elseif (preg_match("#^/white_bread#", $url)) {
    $template = "__object.twig";
    $title = "Белый хлеб";

    $context['url_title'] = "white_bread";
    $is_info = $url == '/white_bread/info';
    $is_image = $url == '/white_bread/image';

    $context['is_info'] = $is_info;
    $context['is_image'] = $is_image;

    if ($is_image) {
        $template = "image.twig";
        $context['image_url'] = '/images/white_bread.png';
    }
    elseif ($is_info) {

        $template = "white_bread_info.twig";
        }
} elseif (preg_match("#^/rye_bread#", $url)) {
    $template = "__object.twig";
    $title = "Ржаной хлеб";

    $context['url_title'] = "rye_bread";
    $is_info = $url == '/rye_bread/info';
    $is_image = $url == '/rye_bread/image';

    $context['is_info'] = $is_info;
    $context['is_image'] = $is_image;

    if ($is_image) {
        $template = "image.twig";
        $context['image_url'] = '/images/rye_bread.png';        
    }
    elseif ($is_info) {
        $template = "rye_bread_info.twig";
        }
}

$context['title'] = $title;
echo $twig->render($template, $context);
