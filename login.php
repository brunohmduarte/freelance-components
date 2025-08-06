<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';

use BrunoDuarte\DatabaseConnection\ConnectionManager;
use App\FullLoginSystem\Models\User;

ConnectionManager::initLogger();
ConnectionManager::loadEnv(__DIR__);

try {
    $pdo = ConnectionManager::connect('mysql');
    if (!$pdo instanceof PDO) {
        throw new PDOException("Erro ao conectar ao MySQL");
    }
    
    list($email, $password, $remember, $userModel) = ['', '', '', new User($pdo)];

    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        $user = $userModel->findBy('remember_token', $token);
    
        if ($user) {
            $_SESSION['user']['user_id']    = $user['user_id'];
            $_SESSION['user']['name']       = $user['name'];
            $_SESSION['user']['email']      = $user['email'];
            $_SESSION['user']['updated_at'] = $user['updated_at'];
            $_SESSION['user']['created_at'] = $user['created_at'];
            
            header('Location: admin/dashboard.php');
            exit;
        }
    }

    if (isset($_GET['error'])) {
        $error = urldecode($_GET['error']) ?? '';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $remember = filter_input(INPUT_POST, 'remember', FILTER_VALIDATE_BOOL);

        /** @todo Carregar as configurações da dashboard e armazenar na sessão */
        $user = $userModel->findBy('email', $email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user']['user_id']    = $user['user_id'];
            $_SESSION['user']['name']       = $user['name'];
            $_SESSION['user']['email']      = $user['email'];
            $_SESSION['user']['updated_at'] = $user['updated_at'];
            $_SESSION['user']['created_at'] = $user['created_at'];

            if ($remember) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_token', $token, time() + 3600 * 24 * 30, '/');
                $userModel->update($user['user_id'], ['remember_token' => $token]);
            }

            header("Location: admin/dashboard.php");
            exit;
        } else {
            $error = "<sapn class='fs-5'>Ops!</sapn> Credenciais inválidas";
        }
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
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
</head>
<body>
    <div class="vh-100 bg-light d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4 text-center">
                    <h2>login</h2>
                    <p class="mb-4">Sistema de autenticação de usuário</p>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger py-1 px-2 text-start"><?php echo $error ?></div>
                    <?php endif; ?>

                    <?php if (isset($_GET['registered']) && $_GET['registered'] === '1'): ?>
                        <div class="alert alert-success py-1 px-2 text-start">Usuário registrado com sucesso!</div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <span class="mdi mdi-account"></span>
                            </span>
                            <input type="text" class="form-control" name="email" id="email" value="<?= $email ?>" placeholder="E-mail" aria-label="E-mail" aria-describedby="basic-addon1">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <span class="mdi mdi-lock"></span>
                            </span>
                            <input type="password" class="form-control" name="password" id="password" value="<?= $password ?>" placeholder="Senha" aria-label="Senha" aria-describedby="basic-addon1">
                        </div>

                        <div class="form-check text-start mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                            <label class="form-check-label" for="remember">Lembrar-me</label>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary mt-3 p-1">
                                <span class="mdi mdi-login fs-5 me-1"></span>
                                <span class="fw-medium text-uppercase">Entrar</span>
                            </button>
                        </div>
                    </form>

                    <span>Ainda sem conta? <a href="register.php" class="ms-1">Cadastre-se</a></span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</body>
</html>
