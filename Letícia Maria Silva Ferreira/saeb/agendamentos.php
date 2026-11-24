<?php
require_once 'conexao.php';

$sucesso = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agendamento_id'])) {
    $id = $_POST['agendamento_id'];
    $nova_data = $_POST['nova_data'];

    $sql = "UPDATE agendamentos SET data_agendamento = :nova_data WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nova_data' => $nova_data, 'id' => $id]);
    $sucesso = "Data do agendamento atualizada com sucesso!";
}

$sql = "SELECT 
            a.id AS agendamento_id,
            a.data_agendamento,
            a.horario,
            a.motivo,
            p.nome AS nome_pet,
            p.especie,
            t.nome AS nome_tutor,
            t.telefone
        FROM agendamentos a
        INNER JOIN pets p ON a.pet_id = p.id
        INNER JOIN tutores t ON p.tutor_id = t.id
        ORDER BY a.data_agendamento ASC, a.horario ASC";
$stmt = $pdo->query($sql);
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Agendamentos</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f0f4f8; color: #333; padding: 20px; }
        .container { max-width: 1050px; margin: 30px auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); }
        h2 { color: #0d6efd; margin-bottom: 15px; }
        a.voltar { color: #0d6efd; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 20px; }
        a.voltar:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #0d6efd; color: white; text-align: left; padding: 12px; }
        td { padding: 10px 12px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        input[type="date"] { padding: 6px; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #198754; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold; transition: 0.2s; }
        button:hover { background-color: #157347; }
        .msg-sucesso { background-color: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 6px; margin-bottom: 15px; border: 1px solid #badbcc; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="voltar">&larr; Voltar ao Menu</a>
        <h2>Gerenciamento de Agendamentos</h2>

        <?php if (!empty($sucesso)): ?>
            <div class="msg-sucesso"><?php echo $sucesso; ?></div>
        <?php endif; ?>

        <table>
            <tr>
                <th>Data do Agendamento</th>
                <th>Horário</th>
                <th>Motivo</th>
                <th>Pet (Espécie)</th>
                <th>Tutor (Telefone)</th>
                <th>Ação</th>
            </tr>
            <?php foreach ($agendamentos as $ag): ?>
            <tr>
                <form method="POST">
                    <input type="hidden" name="agendamento_id" value="<?php echo $ag['agendamento_id']; ?>">
                    <td><input type="date" name="nova_data" value="<?php echo $ag['data_agendamento']; ?>"></td>
                    <td><?php echo $ag['horario']; ?></td>
                    <td><?php echo htmlspecialchars($ag['motivo']); ?></td>
                    <td><?php echo htmlspecialchars($ag['nome_pet'] . " (" . $ag['especie'] . ")"); ?></td>
                    <td><?php echo htmlspecialchars($ag['nome_tutor'] . " - " . $ag['telefone']); ?></td>
                    <td><button type="submit">Atualizar</button></td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>