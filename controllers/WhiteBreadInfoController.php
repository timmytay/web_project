<?php
require_once "WhiteBreadController.php";

class WhiteBreadInfoController extends WhiteBreadController {
    public $template = "white_bread_info.twig";
    public function getContext(): array
    {
        $context = parent::getContext();
        $context['is_info'] = true;
        return $context;
    }
}