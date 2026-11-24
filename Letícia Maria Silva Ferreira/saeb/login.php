<?php
session_start();
require_once 'conexao.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && isset($usuario['senha'])) {
        if ($usuario['senha'] === '123456' && $senha === '123456') { 
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header('Location: dashboard.php');
            exit;
        } else {
            $erro = "E-mail ou palavra-passe incorretos! Tente novamente.";
        }
    } else {
        $erro = "E-mail ou palavra-passe incorretos! Tente novamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Login - Clínica Veterinária</title>
    <style>
        /* Estilos embutidos para garantir que o design funciona a 100% */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f0f4f8;
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #0d6efd;
            margin-bottom: 5px;
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
            color: #444;
            margin-top: 15px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        input:focus {
            border-color: #0d6efd;
            outline: none;
        }
        button {
            width: 100%;
            background-color: #198754;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            margin-top: 20px;
            transition: 0.2s;
        }
        button:hover {
            background-color: #157347;
        }
        .msg-erro {
            background-color: #f8d7da;
            color: #842029;
            padding: 10px;
            border-radius: 6px;
            margin-top: 15px;
            border: 1px solid #f5c2c7;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🐾 Clínica Veterinária</h2>
        <p style="color: #666; font-size: 14px;">Acesso ao sistema</p>

        <?php if (!empty($erro)): ?>
            <div class="msg-erro"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>E-mail:</label>
            <input type="email" name="email" placeholder="ana@clinica.com" required>

            <label>Palavra-passe:</label>
            <input type="password" name="senha" placeholder="******" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>