<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use BrunoDuarte\EventNotifier\EventNotifier;

$notifier = new EventNotifier();
$notifications = $notifier->getUnread();
if (!empty($notifications)) {
    $html = '<div style="width: 300px; padding: 8px; display: flex; flex-direction: column">';

    foreach ($notifications as $notification) {
        $html .= '<div style=" border: 1px solid #ccc; border-radius: 5px; margin-bottom: 8px;  padding: 8px">';
        $html .= '<h4 style="margin: 0 0 16px; text-align: left;">' . $notification['title'] . '</h4>';
        $html .= '<p style="margin: 0 0 16px; text-align: left; font-size: 12px">' . $notification['description'] . '</p>';
        $html .= '<div style="display: flex; justify-content: space-between">';
        $html .= '<a href="#" style="color: #999; font-size: 12px">Ler mais</a>';
        $html .= '<a href="#" style="color: #999; font-size: 12px">Marcar como lida</a>';
        $html .= '</div>';
        $html .='</div>';
    };

    $html .= '</div>';

    echo $html;

} else {
    echo '<p>Nenhuma notificação não encontrada.</p>';
}


