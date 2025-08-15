<?php

namespace BrunoDuarte\EventNotifier;

use BrunoDuarte\EventNotifier\Model\Notification;

/**
 * Class EventNotifier
 */
class EventNotifier
{
    /** 
     * @var Notification $notification 
     */
    public $notification;

    /**
     * EventNotifier constructor.
     */
    public function __construct()
    {
        $this->notification = new Notification();
    }

    /**
     * Registra uma nova notificação
     * 
     * @param string $title Título da notificação
     * @param string $description Breve descrição da notificação
     * @return bool
     */
    public function notify(string $title, string $description): bool
    {
        $data = [
            'title'       => $title,
            'description' => $description,
            'created_at'  => date('Y-m-d H:i:s'),
        ];
        return $this->notification->create($data);
    }

    /**
     * Retorna as notificações não lidas
     * 
     * @return array
     */
    public function getUnread(): array
    {
        return $this->notification->getUnread();
    }

    /**
     * Marca uma notificação como lida
     * 
     * @param int $id
     * @return bool
     */
    public function markAsRead(int $id): bool
    {
        return $this->notification->markAsRead($id);
    }
}
