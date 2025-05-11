<?php
require_once "TwigBaseController.php";

class WhiteBreadController extends TwigBaseController
{

    public $title = "Белый хлеб";
    public $template = "__object.twig";

    public function getContext(): array
    {
        $context = parent::getContext();
        $context['url_title'] = "white_bread";
        return $context;
    }
}
