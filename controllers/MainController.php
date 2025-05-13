<?php
require_once "TwigBaseController.php"; // импортим TwigBaseController

class MainController extends TwigBaseController
{
    public $template = "main.twig";
    public $title = "Главная";

    public function getContext(): array
    {
        $context = parent::getContext();
         $query = $this->pdo->query("SELECT * FROM bread_types");
        
        // стягиваем данные через fetchAll() и сохраняем результат в контекст
        $context['bread_types'] = $query->fetchAll();

        return $context;
    }
}
