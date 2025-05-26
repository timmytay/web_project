<?php

abstract class BaseController {
    public PDO $pdo;
    public array $params;
    private static $sessionStarted = false; // Track if session was started

    public function setPDO(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function setParams(array $params) {
        $this->params = $params;
    }

    public function getContext(): array {
        return [];
    }

    public function process_response() {
        // Initialize session only once per request
        if (!self::$sessionStarted) {
            session_set_cookie_params(60*60*10); // 10 hours
            session_start();
            self::$sessionStarted = true;
        }

        $method = $_SERVER['REQUEST_METHOD'];
        $context = $this->getContext();
        if ($method == 'GET') {
            $this->get($context);
        } else if ($method == 'POST') {
            $this->post($context);
        }
    }

    public function get(array $context) {}
    public function post(array $context) {}
}