<?php
require_once "TwigBaseController.php";

class RyeBreadController extends TwigBaseController
{

    public $title = "Ржаной хлеб";
    public $template = "__object.twig";

    public function getContext(): array
    {
        $context = parent::getContext();
        $context['url_title'] = "rye_bread";
        return $context;
    }
}
