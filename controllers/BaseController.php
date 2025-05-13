<?php

abstract class BaseController {
    public PDO $pdo; // добавил поле

    public function setPDO(PDO $pdo) { // и сеттер для него
        $this->pdo = $pdo;
    }
    // остальное не трогаем
    public function getContext(): array {
        return [];
    }

    abstract public function get();
}