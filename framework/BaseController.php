<?php

abstract class BaseController {
    public PDO $pdo;
    public array $params;
    private static $sessionInitialized = false; // Track if session was initialized

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
        if (!self::$sessionInitialized) {
            if (session_status() === PHP_SESSION_NONE) {
                session_set_cookie_params(60*60*10); // 10 hours
                session_start();
            }
            self::$sessionInitialized = true;
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