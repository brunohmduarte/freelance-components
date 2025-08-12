<?php

namespace BrunoDuarte\UserAuthenticationSystem;

// require_once dirname(__DIR__) . '/vendor/autoload.php';

use BrunoDuarte\DatabaseConnection\ConnectionManager;
use PDO;

abstract class ModelAbstract
{
    protected PDO $connection;

    public function __construct() 
    {
        ConnectionManager::initLogger();
        ConnectionManager::loadEnv(dirname(__DIR__));
        $this->connect();
    }

    private function connect() 
    {
        $this->connection = ConnectionManager::connect('mysql');
        if (!$this->connection instanceof PDO) {
            throw new \Exception("Erro ao conectar ao MySQL");
        }
    }
}