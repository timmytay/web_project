<?php
// controllers/LoginController.php
require_once "BaseBreadTwigController.php";

class LoginController extends BaseBreadTwigController {
    public $template = "login.twig";
    public $title = "Авторизация";

    public function get(array $context) {
        parent::get($context);
    }

    public function post(array $context) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $query = $this->pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $query->bindValue("username", $username);
        $query->bindValue("password", $password);
        $query->execute();

        $user = $query->fetch();

        if ($user) {
            $_SESSION['is_logged'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['message'] = 'Вы успешно авторизованы';
            $_SESSION['message_type'] = 'success';
            header("Location: /");
            exit;
        } else {
            $_SESSION['message'] = 'Неверные учетные данные';
            $_SESSION['message_type'] = 'danger';
            header("Location: /login");
            exit;
        }
    }
}