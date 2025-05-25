<?php

class BaseBreadTwigController extends TwigBaseController {
    public function getContext(): array {
        $context = parent::getContext();

        $query = $this->pdo->query("SELECT id, name, image FROM bread_variants ORDER BY name");
        $types = $query->fetchAll();
        $context['variants'] = $types;

        return $context;
    }
}