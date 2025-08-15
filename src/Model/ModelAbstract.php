<?php

namespace BrunoDuarte\EventNotifier\Model;

use BrunoDuarte\DatabaseConnection\ConnectionManager;

/**
 * Class ModelAbstract
 */
abstract class ModelAbstract
{
    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * ModelAbstract constructor.
     */
    public function __construct()
    {
        ConnectionManager::initLogger();
        ConnectionManager::loadEnv(dirname(__DIR__, 2));
        $this->connect();
    }

    /**
     * Conecta a aplicação com o banco de dados
     * 
     * @throws \Exception
     * @return void
     */
    private function connect() 
    {
        $this->connection = ConnectionManager::connect($_ENV['DRIVER_CONNECTION']);
        if (!$this->connection) {
            throw new \Exception('Database connection failed');
        }
    }
}