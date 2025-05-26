<?php

class VisitHistoryMiddleware extends BaseMiddleware 
{
    public function apply(BaseController $controller, array $context)
    {
        // Убедимся, что сессия запущена
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Инициализируем историю посещений, если ее нет
        if (!isset($_SESSION['visit_history'])) {
            $_SESSION['visit_history'] = [];
        }
        
        // Получаем текущий URL и заголовок
        $current_url = $_SERVER['REQUEST_URI'];
        $current_title = $controller->title ?? 'Без названия';
        
        // Проверяем, не является ли текущая страница уже последней в истории
        $last_visit = $_SESSION['visit_history'][0] ?? null;
        if (!$last_visit || $last_visit['url'] != $current_url) {
            // Добавляем текущий визит в начало массива
            array_unshift($_SESSION['visit_history'], [
                'url' => $current_url,
                'title' => $current_title,
                'time' => date('Y-m-d H:i:s')
            ]);
            
            // Ограничиваем историю 10 последними записями
            $_SESSION['visit_history'] = array_slice($_SESSION['visit_history'], 0, 10);
        }
    }
}