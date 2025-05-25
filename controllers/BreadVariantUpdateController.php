<?php
require_once "BaseBreadTwigController.php";

class BreadVariantUpdateController extends BaseBreadTwigController
{
    public $template = "bread_variant_update.twig";

    public function get(array $context)
    {
        $id = $this->params['id'];
        
        // Get the existing variant data
        $query = $this->pdo->prepare("SELECT * FROM bread_variants WHERE id = :id");
        $query->bindValue("id", $id);
        $query->execute();
        
        $data = $query->fetch();
        $context['variant'] = $data;
        
        parent::get($context);
    }

    public function post(array $context)
    {
        $id = $this->params['id'];
        $name = $_POST['name'];

        // Handle image upload if a new one was provided
        $image_url = null;
        if (!empty($_FILES['image']['name'])) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            move_uploaded_file($tmp_name, "../public/media/$name");
            $image_url = "/media/$name";
        }

        $sql = <<<EOL
UPDATE bread_variants
SET name = :name
EOL;

        // Add image update if new image was uploaded
        if ($image_url) {
            $sql .= ", image = :image_url";
        }

        $sql .= " WHERE id = :id";

        $query = $this->pdo->prepare($sql);
        $query->bindValue("name", $name);
        $query->bindValue("id", $id);
        
        if ($image_url) {
            $query->bindValue("image_url", $image_url);
        }

        $query->execute();
        
        $_SESSION['message'] = 'Тип хлеба успешно обновлен';
        $_SESSION['message_type'] = 'success';
        
        header("Location: /bread-variants");
        exit;
    }
}