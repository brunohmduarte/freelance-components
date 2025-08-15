<?php

date_default_timezone_set('America/Sao_Paulo');

require_once dirname(__DIR__) . '/vendor/autoload.php';

use BrunoDuarte\EventNotifier\EventNotifier;

$notifier = new EventNotifier();

// Inserindo um novo evento
$register = $notifier->notify(
    'Login realizado com sucesso', 
    'O usuário Joe Coe fez login no painel administrativo.'
);

if (!$register) {
    echo '<p>Não foi possível cadastrar notificação.</p>';
} else {
    echo '<p>Notificação cadastrada com sucesso.</p>';
}


