<?php

class BaseBreadTwigController extends TwigBaseController {
    public function getContext(): array {
        $context = parent::getContext();

        $query = $this->pdo->query("SELECT id, name, image FROM bread_variants ORDER BY name");
        $types = $query->fetchAll();
        $context['variants'] = $types;

        // Добавляем поддержку flash-сообщений
        if (isset($_SESSION['message'])) {
            $context['message'] = $_SESSION['message'];
            $context['message_type'] = $_SESSION['message_type'] ?? 'success';
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }

                // Добавляем историю посещений в контекст
        $context['visit_history'] = $_SESSION['visit_history'] ?? [];
        
        return $context;
    }
}