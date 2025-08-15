<?php

namespace BrunoDuarte\EventNotifier\Model;

use BrunoDuarte\EventNotifier\Model\ModelAbstract;
use BrunoDuarte\DatabaseConnection\CrudTrait;

/**
 * Class Notification
 */
class Notification extends ModelAbstract
{
    use CrudTrait;

    /**
     * Notification constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'notifications';
        $this->tableId = 'notification_id';
        $this->setConnection($this->connection);
    }

    /**
     * Retorna as notificações não lidas
     * 
     * @return array
     */
    public function getUnread(): array
    {
        $sql = "SELECT * FROM notifications WHERE is_read = :is_read ORDER BY created_at DESC;";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':is_read', 0, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Marca uma notificação como lida
     * 
     * @param int $id
     * @return bool
     */
    public function markAsRead(int $id): bool
    {
        return $this->update($id, ["is_read" => 1]);
    }
}