<?php
require_once "BaseBreadTwigController.php";

class BreadObjectUpdateController extends BaseBreadTwigController
{
    public $template = "bread_object_update.twig";

    public function get(array $context)
    {
        $id = $this->params['id'];
        
        // Get the existing object data
        $query = $this->pdo->prepare("SELECT * FROM bread_types WHERE id = :id");
        $query->bindValue("id", $id);
        $query->execute();
        
        $data = $query->fetch();
        $context['object'] = $data;
        
        parent::get($context);
    }

    public function post(array $context)
    {
        $id = $this->params['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = (int)$_POST['type'];
        $info = $_POST['info'];

        // Handle image upload if a new one was provided
        $image_url = null;
        if (!empty($_FILES['image']['name'])) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            move_uploaded_file($tmp_name, "../public/media/$name");
            $image_url = "/media/$name";
        }

        $sql = <<<EOL
UPDATE bread_types
SET title = :title,
    description = :description,
    type = :type,
    info = :info
EOL;

        // Add image update if new image was uploaded
        if ($image_url) {
            $sql .= ", image = :image_url";
        }

        $sql .= " WHERE id = :id";

        $query = $this->pdo->prepare($sql);
        $query->bindValue("title", $title);
        $query->bindValue("description", $description);
        $query->bindValue("type", $type);
        $query->bindValue("info", $info);
        $query->bindValue("id", $id);
        
        if ($image_url) {
            $query->bindValue("image_url", $image_url);
        }

        $query->execute();
        
        $_SESSION['message'] = 'Объект успешно обновлен';
        $_SESSION['message_type'] = 'success';
        
        header("Location: /bread-object/{$id}");
        exit;
    }
}