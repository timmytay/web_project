<?php
require_once "BaseBreadTwigController.php";
class MainController extends BaseBreadTwigController
{
    public $template = "main.twig";
    public $title = "Главная";

    public function getContext(): array
    {
        $context = parent::getContext();
        if (isset($_GET['type'])) {
            $query = $this->pdo->prepare("SELECT * FROM bread_types WHERE type = :type");
            $query->bindValue("type", $_GET['type']);
            $query->execute();
        } else {
            $query = $this->pdo->query("SELECT * FROM bread_types");
        }
        $context['bread_types'] = $query->fetchAll();

        return $context;
    }
}