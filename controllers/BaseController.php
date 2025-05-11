<?php
abstract class BaseController {
    public function getContext(): array {
        return [];
    }    
    abstract public function get();
}