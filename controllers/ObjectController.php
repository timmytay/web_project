<?php
require_once "BaseBreadTwigController.php";
class ObjectController extends BaseBreadTwigController
{
    public $template = "__object.twig";

    public function getContext(): array
    {
        $context = parent::getContext();
        $id = $this->params['id'] ?? null;
        
        if ($id) {
            $stmt = $this->pdo->prepare("SELECT * FROM bread_types WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch();
            
            if ($data) {
                $context['object'] = $data;
                $this->title = $data['title'] ?? '';
                $context['description'] = $data['description'];
                $context['info'] = $data['info'];
                $context['image_url'] = $data['image'];
                
                // Determine what to show based on GET parameter
                $show = $_GET['show'] ?? '';
                if ($show === 'image') {
                    $context['is_image'] = true;
                } elseif ($show === 'info') {
                    $context['is_info'] = true;
                }
            } else {
                $context['object'] = null;
                $this->title = "Объект не найден";
            }
        } else {
            $context['object'] = null;
            $this->title = "ID не указан";
        }

        return $context;
    }
}