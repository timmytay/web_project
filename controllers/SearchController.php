<?php
require_once "BaseBreadTwigController.php";

class SearchController extends BaseBreadTwigController
{
    public $template = "search.twig";
    public $title = "Поиск";
    
    public function getContext(): array
    {
        $context = parent::getContext();
        
        // Check if search was performed (any parameter exists)
        $search_performed = !empty($_GET);
        
        // Get parameters from GET request with default values
        $type = $_GET['type'] ?? '';
        $title = $_GET['title'] ?? '';
        $description = $_GET['description'] ?? '';

        $context['search_performed'] = $search_performed;
        $context['type'] = $type;
        $context['title'] = $title;
        $context['description'] = $description;
        $context['objects'] = [];

        if ($search_performed) {
            $sql = <<<EOL
            SELECT b.id, b.title, b.description, b.type, v.name as type_name
            FROM bread_types b
            LEFT JOIN bread_variants v ON b.type = v.id
            WHERE (:title = '' OR b.title like CONCAT('%', :title, '%'))
            AND (:type = '' OR b.type = :type)
            AND (:description = '' OR b.description like CONCAT('%', :description, '%'))
            EOL;

            $query = $this->pdo->prepare($sql);
            $query->bindValue("title", $title);
            $query->bindValue("type", $type);
            $query->bindValue("description", $description);
            $query->execute();
            
            $context['objects'] = $query->fetchAll();
        }

        return $context;
    }
}