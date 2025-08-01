<?php

namespace DatabaseConnection\Models;

use DatabaseConnection\Database\CrudTrait;

class Store
{
    use CrudTrait;

    public function __construct(\PDO $pdo)
    {
        $this->setConnection($pdo);
        $this->table = 'stores';
        $this->tableId = 'store_id';
    }
}
