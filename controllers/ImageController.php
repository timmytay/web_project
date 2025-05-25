<?php
class ImageController extends TwigBaseController
{
    public $template = "image.twig"; // шаблон для изображений

    public function getContext(): array
    {
        $context = parent::getContext();

        $query = $this->pdo->prepare("SELECT description, image FROM bread_types WHERE id = :my_id");
        $query->bindValue("my_id", $this->params['id']);
        $query->execute(); 
        $data = $query->fetch();

        $context['is_image'] = true;
        $context['description'] = $data['description'];
        $context['image_url'] = $data['image']; // URL изображения из БД

        return $context;
    }
}