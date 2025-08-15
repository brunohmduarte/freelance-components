<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use BrunoDuarte\EventNotifier\EventNotifier;

$notifier = new EventNotifier();

// Marcando uma notificação como lida
if ($notifier->markAsRead(1)) {
    echo '<p>Notificação marcada como lida</p>';
} else {
    echo '<p>Não foi possivel marcar notificação como lida</p>';
}
