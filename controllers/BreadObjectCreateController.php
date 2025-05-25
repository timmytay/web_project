<?php
require_once "BaseBreadTwigController.php";

class BreadObjectCreateController extends BaseBreadTwigController
{
    public $template = "bread_object_create.twig";

    public function get(array $context)
    {
        echo $_SERVER['REQUEST_METHOD'];

        parent::get($context);
    }

    public function post(array $context)
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = (int)$_POST['type'];
        $info = $_POST['info'];

        $tmp_name = $_FILES['image']['tmp_name'];
        $name =  $_FILES['image']['name'];
        move_uploaded_file($tmp_name, "../public/media/$name");
        $image_url = "/media/$name";

        $sql = <<<EOL
INSERT INTO bread_types(title, description, type, info, image)
VALUES(:title, :description, :type, :info, :image_url) -- передаем переменную в запрос
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue("title", $title);
        $query->bindValue("description", $description);
        $query->bindValue("type", $type);
        $query->bindValue("info", $info);
        $query->bindValue("image_url", $image_url);
        $query->execute();
        
        $context['message'] = 'Вы успешно создали объект';
        $context['id'] = $this->pdo->lastInsertId();

        $this->get($context);
    }
}