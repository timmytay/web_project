<?php
require_once "RyeBreadController.php";

class RyeBreadInfoController extends RyeBreadController {
    public $template = "rye_bread_info.twig";
    public function getContext(): array
    {
        $context = parent::getContext();
        $context['is_info'] = true;
        return $context;
    }
}