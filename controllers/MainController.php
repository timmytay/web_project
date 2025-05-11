<?php
require_once "TwigBaseController.php"; // импортим TwigBaseController

class MainController extends TwigBaseController
{
    public $template = "main.twig";
    public $title = "Главная";

    public function getContext(): array
    {
        $context = parent::getContext();
        $context['menu_items'] = [
            [
                "title" => "Белый хлеб",
                "url_title" => "white_bread",
            ],
            [
                "title" => "Ржаной хлеб",
                "url_title" => "rye_bread",
            ],
        ];
        return $context;
    }
}
