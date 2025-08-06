<?php

namespace App\FullLoginSystem\Midllewares;

class AuthMiddleware 
{
    public static function requireAuth() 
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ../login.php?error='.urlencode('Acesso negado!'));
            exit;
        }
    }
}
