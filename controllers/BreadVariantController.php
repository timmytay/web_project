<?php
require_once "BaseBreadTwigController.php";

class BreadVariantController extends BaseBreadTwigController {
    public $template = "bread_variant.twig";
    public $title = "Типы хлеба";

    public function getContext(): array {
        $context = parent::getContext();
        
        // Получаем все типы хлеба
        $query = $this->pdo->query("SELECT * FROM bread_variants ORDER BY name");
        $context['variants'] = $query->fetchAll();

        return $context;
    }

    public function post(array $context) {
        // Обработка добавления нового типа
        $name = $_POST['name'];
        
        // Загрузка изображения
        $tmp_name = $_FILES['image']['tmp_name'];
        $file_name =  $_FILES['image']['name'];
        move_uploaded_file($tmp_name, "../public/media/$file_name");
        $image_url = "/media/$file_name";

        $sql = "INSERT INTO bread_variants (name, image) VALUES (:name, :image)";
        $query = $this->pdo->prepare($sql);
        $query->bindValue("name", $name);
        $query->bindValue("image", $image_url);
        $query->execute();

        $context['message'] = 'Тип хлеба успешно добавлен';
        $this->get($context);
    }
}