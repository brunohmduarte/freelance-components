<?php

namespace BrunoDuarte\UserAuthenticationSystem;

// require_once dirname(__DIR__) . '/vendor/autoload.php';

use BrunoDuarte\DatabaseConnection\CrudTrait;
use BrunoDuarte\UserAuthenticationSystem\ModelAbstract;

class User extends ModelAbstract
{
    use CrudTrait;

    public function __construct() 
    {
        parent::__construct();
        $this->setConnection($this->connection);
        $this->table = 'users_auth';
        $this->tableId = 'user_id';
    }
}