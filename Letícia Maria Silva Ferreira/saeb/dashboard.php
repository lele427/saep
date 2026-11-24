<?php
session_start();
if (!isset($_SESSION['usuario_nome'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Painel Principal - Clínica Veterinária</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f0f4f8; color: #333; padding: 20px; }
        .container { max-width: 900px; margin: 40px auto; background: #ffffff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); }
        h1 { color: #0d6efd; margin-bottom: 10px; }
        p { color: #666; margin-bottom: 25px; }
        .menu-lista { list-style: none; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .menu-lista li a { display: block; background: #e7f1ff; padding: 25px; border-radius: 8px; text-align: center; font-weight: bold; color: #0d6efd; border: 1px solid #b6d4fe; text-decoration: none; transition: 0.2s; }
        .menu-lista li a:hover { background: #0d6efd; color: #fff; }
        .btn-sair { display: inline-block; background-color: #dc3545; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: 0.2s; }
        .btn-sair:hover { background-color: #bb2d3b; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
        <p>Selecione uma opção abaixo para gerenciar a clínica:</p>

        <ul class="menu-lista">
            <li><a href="tutores.php">👤 Gerenciar Tutores</a></li>
            <li><a href="pets.php">🐶 Cadastrar Pets</a></li>
            <li><a href="agendamentos.php">📅 Agendamentos</a></li>
        </ul>

        <a href="logout.php" class="btn-sair">Terminar Sessão (Logout)</a>
    </div>
</body>
</html>