<?php
require_once 'conexao.php';

$sucesso = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];
    $tutor_id = $_POST['tutor_id'];

    $sql = "INSERT INTO pets (nome, especie, raca, idade, tutor_id) VALUES (:nome, :especie, :raca, :idade, :tutor_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $nome, 'especie' => $especie, 'raca' => $raca, 'idade' => $idade, 'tutor_id' => $tutor_id]);
    $sucesso = "Pet cadastrado e associado ao tutor com sucesso!";
}

$tutores = $pdo->query("SELECT id, nome FROM tutores")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Pet</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f0f4f8; color: #333; padding: 20px; }
        .container { max-width: 600px; margin: 30px auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); }
        h2 { color: #0d6efd; margin-bottom: 15px; }
        a.voltar { color: #0d6efd; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 20px; }
        a.voltar:hover { text-decoration: underline; }
        label { font-weight: 600; display: block; margin-bottom: 5px; color: #444; margin-top: 15px; }
        input[type="text"], input[type="number"], select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
        button { width: 100%; background-color: #198754; color: white; border: none; padding: 12px; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: bold; margin-top: 25px; transition: 0.2s; }
        button:hover { background-color: #157347; }
        .msg-sucesso { background-color: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 6px; margin-bottom: 15px; border: 1px solid #badbcc; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="voltar">&larr; Voltar ao Menu</a>
        <h2>Cadastro de Novo Pet</h2>

        <?php if (!empty($sucesso)): ?>
            <div class="msg-sucesso"><?php echo $sucesso; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Nome do Pet:</label>
            <input type="text" name="nome" required>

            <label>Espécie:</label>
            <input type="text" name="especie" placeholder="Ex: Cachorro, Gato..." required>

            <label>Raça:</label>
            <input type="text" name="raca">

            <label>Idade:</label>
            <input type="number" name="idade">

            <label>Selecionar Tutor (Obrigatório):</label>
            <select name="tutor_id" required>
                <option value="">Selecione um tutor</option>
                <?php foreach ($tutores as $t): ?>
                    <option value="<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['nome']); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Cadastrar Pet</button>
        </form>
    </div>
</body>
</html>