<?php

require __DIR__ . '/vendor/autoload.php';

use DatabaseConnection\Database\ConnectionManager;
use DatabaseConnection\Models\Store;

ConnectionManager::initLogger();
ConnectionManager::loadEnv(__DIR__);

try {
    // Conexão MySQL
    $pdo = ConnectionManager::connect('mysql');
    if (!$pdo instanceof PDO) {
        throw new \Exception("Erro ao conectar ao MySQL");
    }
    
    $store = new Store($pdo);
    // Criação
    // $result =$store->create([
    //     'name'    => 'Sete Digital',
    //     'cnpj'    => '40.990.645/0001-33',
    //     'email'   => 'contato@sete.digital',
    //     'contact' => '(14) 99656-2170'
    // ]);
    // if ($result) {
    //     echo 'Cadastrado com sucesso!' . PHP_EOL;
    // }


    // Listagem
    // $stores = $store->all();
    // foreach ($stores as $key => $value) {
    //     echo '<p>'. $key . ' - ' . $value['name'] . ' - ' . $value['cnpj'] . ' - ' . $value['email'] . ' - ' . $value['contact'] . '</p>';
    // }


    // Busca por ID
    // $info = $store->findById(1);
    // echo '<pre>'. print_r($info, true) .'</pre>';


    // Busca por CNPJ
    // $info = $store->findBy('email', 'atendimento@bis2bis.com.br');
    // echo '<pre>'. print_r($info, true) .'</pre>';


    // Atualização
    // $result = $store->update(3, [
    //     'contact' => '14996562170'
    // ]);
    // if ($result) {
    //     echo 'Atualizado com sucesso!' . PHP_EOL;
    // }

    // Remoção
    // $result = $store->delete(3);
    // if ($result) {
    //     echo 'Removido com sucesso!' . PHP_EOL;
    // }

    
} catch (\PDOException $e) {
    echo "MySQL: " . $e->getMessage() . PHP_EOL;
}