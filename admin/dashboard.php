<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\FullLoginSystem\Midllewares\AuthMiddleware;
use BrunoDuarte\DatabaseConnection\ConnectionManager;

AuthMiddleware::requireAuth();

ConnectionManager::initLogger();
ConnectionManager::loadEnv(dirname(__DIR__, 1));

try {
    $pdo = ConnectionManager::connect('mysql');
    if (!$pdo instanceof PDO) {
        throw new PDOException("Erro ao conectar ao MySQL");
    }

} catch (Exception $e) {
    $error = '<sapn class="fs-5">Ops!</sapn>' . $e->getMessage();
} catch (PDOException $e) {
    $error = '<sapn class="fs-5">Ops!</sapn>' . $e->getMessage();
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <p>Bem-vindo, <?= $_SESSION['user']['name'] ?></p>
        <a href="../logout.php" class="btn btn-danger mb-3">Sair</a>

        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</body>
</html>
