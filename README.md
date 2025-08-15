# Sistema de Notificação

Componente para gerenciamento de notificações de eventos no sistema.

---

### 🚀 Informações
Essas instruções permitirão que você obtenha uma cópia desse componente em sua aplicação para auxíliar no gerenciamento de eventos de notificação pelo o seu sistema.

Abaixo, você encontrará instrusções de como instalar, configurar e utilizar os recursos que este componente disponibiliza.


### 📋 Pré-requisitos

- PHP >= 7.0


### 🔧 Instalação

```
composer require brunoduarte/event-notifier
```


### ⚙️ Configuração

Após a instalação do componente via composer, siga o passo-a-passo abaixo para obter a configuração correta do componente afim de evitar possíveis erros em sua aplicação:

- Importe o arquivo **database.sql** que está na raiz do componente em seu banco de dados para criar a tabela.
- Copie o seguinte arquivo de configuração do banco de dados para a raiz do projeto.
    ```
    vendor/brunoduarte/database-connection/.env-example
    ```
- Renomeie o arquivo **.env-example** para **.env**.
- Preencha com os valores corretos de sua conexão como de dados.
- Adicione ao final desse arquivo a seguinte configuração:
    ```
    DRIVER_CONNECTION= // Adicione mysql ou pgsql para definir qual será o driver de connexão com o banco de dados.
    ```


### 🚧 Utilização

**Adicionando um evento de notificação**
```php
<?php

date_default_timezone_set('America/Sao_Paulo');

require_once dirname(__DIR__) . '/vendor/autoload.php';

use BrunoDuarte\EventNotifier\EventNotifier;

$notifier = new EventNotifier();
$register = $notifier->notify(
    'Login realizado com sucesso', 
    'O usuário Joe Coe fez login no painel administrativo.'
);

if (!$register) {
    echo '<p>Não foi possível cadastrar notificação.</p>';
} else {
    echo '<p>Notificação cadastrada com sucesso.</p>';
}
```

**Listando as notificações não lidas**
```php
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
```

**Marcando uma notificação como lida**
```php
if ($notifier->markAsRead(1)) { // 1 se refere ao id da notificação.
    echo '<p>Notificação marcada como lida</p>';
} else {
    echo '<p>Não foi possivel marcar notificação como lida</p>';
}
```


### 📌 Versão

Nós usamos [SemVer](http://semver.org/) para controle de versão. Para as versões disponíveis, observe as tags neste repositório.


### ✒️ Autor

Bruno H. M. Duarte - Desenvolvedor de aplicações para Web