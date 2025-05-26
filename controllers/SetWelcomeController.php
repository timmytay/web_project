<?php

class SetWelcomeController extends BaseController {
    public function get(array $context) {
        $_SESSION['welcome_message'] = $_GET['message']; // добавил
        
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }

        array_push($_SESSION['messages'], $_GET['message']);

        $url = $_SERVER['HTTP_REFERER'];
        header("Location: $url");
        exit;
    }
}