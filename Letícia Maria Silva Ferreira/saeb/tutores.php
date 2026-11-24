<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_tutor'])) {
    $id = $_POST['id_tutor'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    
    $sql = "UPDATE tutores SET nome = :nome, telefone = :telefone WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $nome, 'telefone' => $telefone, 'id' => $id]);
    $sucesso = "Tutor atualizado com sucesso!";
}

$termo = $_GET['busca'] ?? '';
$sql = "SELECT id, nome, CAST(AES_DECRYPT(cpf, 'chave_secreta_lgpd') AS CHAR) AS cpf, telefone FROM tutores WHERE nome LIKE :termo";
$stmt = $pdo->prepare($sql);
$stmt->execute(['termo' => "%$termo%"]);
$tutores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Tutores</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f0f4f8; color: #333; padding: 20px; }
        .container { max-width: 1000px; margin: 30px auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); }
        h2 { color: #0d6efd; margin-bottom: 15px; }
        a.voltar { color: #0d6efd; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 20px; }
        a.voltar:hover { text-decoration: underline; }
        form.busca { display: flex; gap: 10px; margin-bottom: 20px; }
        input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
        button { background-color: #198754; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.2s; }
        button:hover { background-color: #157347; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #0d6efd; color: white; text-align: left; padding: 12px; }
        td { padding: 10px 12px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        td input[type="text"] { width: 100%; padding: 6px; }
        .msg-sucesso { background-color: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 6px; margin-bottom: 15px; border: 1px solid #badbcc; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="voltar">&larr; Voltar ao Menu</a>
        <h2>Gerenciamento de Tutores</h2>

        <?php if (!empty($sucesso)): ?>
            <div class="msg-sucesso"><?php echo $sucesso; ?></div>
        <?php endif; ?>

        <form method="GET" class="busca">
            <input type="text" name="busca" placeholder="Buscar tutor por nome..." value="<?php echo htmlspecialchars($termo); ?>">
            <button type="submit">Pesquisar</button>
        </form>

        <table>
            <tr>
                <th>Nome</th>
                <th>CPF (Descriptografado - LGPD)</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($tutores as $tutor): ?>
            <tr>
                <form method="POST">
                    <input type="hidden" name="id_tutor" value="<?php echo $tutor['id']; ?>">
                    <td><input type="text" name="nome" value="<?php echo htmlspecialchars($tutor['nome']); ?>"></td>
                    <td><?php echo htmlspecialchars($tutor['cpf']); ?></td>
                    <td><input type="text" name="telefone" value="<?php echo htmlspecialchars($tutor['telefone']); ?>"></td>
                    <td><button type="submit">Salvar</button></td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>