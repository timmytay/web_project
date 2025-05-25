<?php
require_once "BaseBreadTwigController.php";

class BreadVariantDeleteController extends BaseBreadTwigController {
    public function post(array $context) {
        $id = $this->params['id'];

        // Проверяем, есть ли объекты, использующие этот тип
        $checkQuery = $this->pdo->prepare("SELECT COUNT(*) as count FROM bread_types WHERE type = :type");
        $checkQuery->bindValue("type", $id);
        $checkQuery->execute();
        $result = $checkQuery->fetch();

        if ($result['count'] > 0) {
            $_SESSION['message'] = 'Нельзя удалить тип, так как существуют объекты хлеба этого типа';
            $_SESSION['message_type'] = 'danger';
        } else {
            $sql = "DELETE FROM bread_variants WHERE id = :id";
            $query = $this->pdo->prepare($sql);
            $query->bindValue("id", $id);
            $query->execute();

            $_SESSION['message'] = 'Тип хлеба успешно удален';
            $_SESSION['message_type'] = 'success';
        }

        header("Location: /bread-variants");
        exit;
    }
}