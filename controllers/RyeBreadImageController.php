<?php
require_once "RyeBreadController.php";

class RyeBreadImageController extends RyeBreadController {
    public $template = "image.twig";
    public function getContext(): array
    {
        $context = parent::getContext();
        $context['is_image'] = true;
        $context['image_url'] = '/images/rye_bread.png';
        return $context;
    }
}