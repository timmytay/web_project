<?php
class LoginRequiredMiddleware extends BaseMiddleware 
{
    public function apply(BaseController $controller, array $context)
    {
        // Если пользователь уже авторизован через сессию
        if (isset($_SESSION['user_id'])) {
            return;
        }

        // Проверяем HTTP Basic Auth
        $authUser = $_SERVER['PHP_AUTH_USER'] ?? null;
        $authPass = $_SERVER['PHP_AUTH_PW'] ?? null;

        if ($authUser !== null && $authPass !== null) {
            // Ищем пользователя в БД
            $stmt = $controller->pdo->prepare("SELECT id, password FROM users WHERE username = :username");
            $stmt->bindValue(':username', $authUser);
            $stmt->execute();
            
            $user = $stmt->fetch();

            // Прямое сравнение паролей (без хеширования)
            if ($user && $authPass === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                return; // Авторизация успешна
            }
            
            // Если учетные данные неверные
            unset($_SERVER['PHP_AUTH_USER']);
            unset($_SERVER['PHP_AUTH_PW']);
            $_SESSION['auth_attempted'] = true;
        }

        // Всегда показываем окно авторизации
        header('WWW-Authenticate: Basic realm="Bread Admin Panel"');
        header('HTTP/1.0 401 Unauthorized');
        
        // Если была попытка авторизации, показываем сообщение
        if (isset($_SESSION['auth_attempted'])) {
            unset($_SESSION['auth_attempted']);
            echo 'Неверные учетные данные. Пожалуйста, введите правильные логин и пароль.';
        } else {
            echo 'Для доступа необходимо авторизоваться';
        }
        
        exit;
    }
}