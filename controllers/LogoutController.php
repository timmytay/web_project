<?php
// controllers/LogoutController.php
require_once __DIR__ . "/../framework/BaseController.php";

class LogoutController extends BaseController {
    public function post(array $context) {
        $this->performLogout();
        header("Location: /login");
        exit;
    }
    
    private function performLogout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), 
                '', 
                time() - 42000,
                $params["path"], 
                $params["domain"],
                $params["secure"], 
                $params["httponly"]
            );
        }
        
        session_destroy();
    }
}