<?php

abstract class BaseController {
    public PDO $pdo;
    public array $params;

    public function setPDO(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function setParams(array $params) {
        $this->params = $params;
    }

    public function getContext(): array {
        return [];
    }

    abstract public function get();
}