<?php
require_once "WhiteBreadController.php";

class WhiteBreadImageController extends WhiteBreadController {
    public $template = "image.twig";
    public function getContext(): array
    {
        $context = parent::getContext();
        $context['is_image'] = true;
        $context['image_url'] = '/images/white_bread.png';
        return $context;
    }
}