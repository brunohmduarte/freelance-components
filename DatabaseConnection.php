<?php

class DatabaseConnection
{
    private string $driver;
    private string $host;
    private int $port;
    private string $dbname;
    private string $username;
    private string $password;
    private ?PDO $connection = null;

    public function __construct(
        string $driver,
        string $host,
        int $port,
        string $dbname,
        string $username,
        string $password
    ) {
        if (!in_array($driver, ['mysql', 'pgsql'])) {
            throw new InvalidArgumentException("Driver inválido. Use 'mysql' ou 'pgsql'.");
        }

        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect(): PDO
    {
        if ($this->connection) {
            return $this->connection;
        }

        // Utilizado para as versões mais recentes do PHP 8.0+
        // $dsn = match ($this->driver) {
        //     'mysql' => "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4",
        //     'pgsql' => "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}",
        // };

        // Utilizado para as versões do PHP 7.4+
        switch ($this->driver) {
            case 'mysql': 
                $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
                break;
            
            case 'pgsql':
                $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
                break;

            default:
                throw new InvalidArgumentException("Driver inválido.");
        }
        

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }

        return $this->connection;
    }

    public function getConnection(): PDO
    {
        return $this->connect();
    }
}
