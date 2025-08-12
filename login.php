<?php
    session_start();

    require_once 'vendor/autoload.php';

    use BrunoDuarte\UserAuthenticationSystem\User;

    try {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email    = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            $userModel = new User();

            $user = $userModel->findBy('email', $email);
            if (!$user) {
                Throw new \Exception("Usuário ou senha inválidos");
            }

            // Implementação da lógica para autenticar o usuário

            $_SESSION['user'] = $user;
            switch ($user['role']) {
                case 'admininstrator':  header('Location: admin/administrator.php'); break;
                case 'user':            header('Location: admin/user.php');          break;
                default:                header('Location: login.php');               break;
            }
        }

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            background-color: #f2f2f2;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-form {
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-form p.error {
            color: red;
            margin-bottom: 16px;
            text-align: center;
        }
        .login-form form {
            width: 100%;
        }
        .login-form h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-form label {
            display: block;
            margin-bottom: 8px;
        }
        .login-form input[type="email"],
        .login-form input[type="password"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-form .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-form btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h1>Login</h1>

            <?php if (isset($error)): ?>
                <p class="error"><?= $error; ?></p>
            <?php endif; ?>

            <form action="login.php" method="post" onsubmit="return validateForm()" novalidate>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="bruno@teste.com" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="teste123" required>

                <input type="submit" class="btn" value="Entrar">
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            // Lógica para validar o formulário
            return true;
        }
    </script>
</body>
</html>