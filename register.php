<?php

require __DIR__ . '/vendor/autoload.php';

use BrunoDuarte\DatabaseConnection\ConnectionManager;
use App\FullLoginSystem\Models\User;

ConnectionManager::initLogger();
ConnectionManager::loadEnv(__DIR__);

try {
    $pdo = ConnectionManager::connect('mysql');
    if (!$pdo instanceof PDO) {
        throw new PDOException("Erro ao conectar ao MySQL");
    }

    list($name, $email, $password, $confirmPassword, $userModel) = ['', '', '', '', new User($pdo)];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name            = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email           = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password        = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $confirmPassword = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);
        $canGeneratePswd = true;

        if (!$email) {
            $error = "<sapn class='fs-5'>Ops!</sapn> E-mail inválido!";
            $canGeneratePswd = false;
        }

        if (strlen($password) < 6) {
            $error = "<sapn class='fs-5'>Ops!</sapn> Senha deve ter pelo menos 6 caracteres.";
            $canGeneratePswd = false;
        }

        if ($password !== $confirmPassword) {
            $error = "<sapn class='fs-5'>Ops!</sapn> As senhas devem ser iguais.";
            $canGeneratePswd = false;
        }

        if ($canGeneratePswd) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $userModel->create(['email' => $email, 'password' => $hash]);
    
            header("Location: login.php?registered=1");
        }

    }

} catch (Exception $e) {
    $error = '<sapn class="fs-5">Ops!</sapn>' . $e->getMessage();
} catch (PDOException $e) {
    $error = '<sapn class="fs-5">Ops!</sapn>' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
</head>
<body>
    <div class="vh-100 bg-light d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4 text-center">
                    <h2>Registrar</h2>
                    <p class="mb-4">Registro de novo usuário</p>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger py-1 px-2 text-start"><?php echo $error ?></div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <span class="mdi mdi-account"></span>
                            </span>
                            <input type="text" class="form-control" name="name" id="name" value="<?= $name ?>" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <span class="mdi mdi-at"></span>
                            </span>
                            <input type="text" class="form-control" name="email" id="email" value="<?= $email ?>" placeholder="E-mail" aria-label="E-mail" aria-describedby="basic-addon1">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <span class="mdi mdi-lock"></span>
                            </span>
                            <input type="password" class="form-control" name="password" id="password" value="<?= $password ?>" placeholder="Senha" aria-label="Senha" aria-describedby="basic-addon1">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <span class="mdi mdi-lock"></span>
                            </span>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="<?= $confirmPassword ?>" placeholder="Confirmar Senha" aria-label="Confirmar Senha" aria-describedby="basic-addon1">
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary mt-3 p-1">
                                <span class="mdi mdi-login fs-5 me-1"></span>
                                <span class="fw-medium text-uppercase">Registrar</span>
                            </button>
                        </div>
                    </form>


                    <span>Eu já tenho uma conta. <a href="login.php" class="ms-1">Entrar</a></span>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</body>
</html>
