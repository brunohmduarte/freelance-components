<?php

date_default_timezone_set('America/Sao_Paulo' );

class FAQRepository
{
    private static \PDO $conn;

    private string $driver;
    private string $host;
    private string $database;
    private string $charset;

    private static string $user;
    private static string $password;
    private static string $dsn;

    public function __construct(string $driver, string $host, string $database, string $user, string $password)
    {
        $this->driver   = $driver;
        $this->host     = $host;
        $this->database = $database;
        $this->charset  = 'utf8';
        self::$user     = $user;
        self::$password = $password;
        self::$dsn      = "{$this->driver}:host={$this->host};dbname={$this->database};charset={$this->charset}";
    }

    /**
     * Connect to database
     * 
     * @return void
     */
    public static function connect(): void
    {
        // self::$conn = new \PDO('mysql:host=127.0.0.1;dbname=freelance;charset=utf8', 'root', 'magento');
        self::$conn = new \PDO(self::$dsn, self::$user, self::$password);
        self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function findAll(): array
    {
        $stmt = self::$conn->query("SELECT * FROM faqs ORDER BY id ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array
    {
        $stmt = self::$conn->prepare("SELECT * FROM faqs WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $return = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (empty($return)) {
            return [];
        }
        
        return $return;
    }

    public function insert(string $question, string $answer, string $active): void
    {
        $currentDate = date('Y-m-d H:i:s');
        $stmt = self::$conn->prepare("INSERT INTO faqs (
            question, answer, active, created_at, updated_at
        ) VALUES (
            :question, :answer, :active, :created_at, :updated_at
        )");

        $stmt->execute([
            'question'   => $question,
            'answer'     => $answer,
            'active'     => $active,
            'created_at' => $currentDate,
            'updated_at' => $currentDate
        ]);
    }

    /**
     * Update a question
     * 
     * @param mixed $id Identifier of the question in the database
     * @param mixed $question
     * @param mixed $answer
     * @param mixed $active
     * @return bool
     */
    public function update($id, $question, $answer, $active): bool
    {
        $stmt = self::$conn->prepare("UPDATE faqs SET
            question = :question,
            answer = :answer,
            active = :active,
            updated_at = :updated_at
            WHERE id = :id
        ");

        $result = $stmt->execute([
            'id'         => $id,
            'question'   => $question,
            'answer'     => $answer,
            'active'     => $active,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $result;
    }

    /**
     * Delete a question
     * 
     * @param int $id Identifier of the question in the database
     * @return void
     */
    public function delete(int $id): void
    {
        $stmt = self::$conn->prepare("DELETE FROM faqs WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

}