<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tarefa = $_POST['tarefa'];
    $stmt = $pdo->prepare("INSERT INTO anotacoes (usuario_id, tarefa) VALUES (:usuario_id, :tarefa)");
    $stmt->execute(['usuario_id' => $usuario_id, 'tarefa' => $tarefa]);
}

$stmt = $pdo->prepare("SELECT * FROM anotacoes WHERE usuario_id = :usuario_id");
$stmt->execute(['usuario_id' => $usuario_id]);
$anotacoes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Dashboard</h2>
    <form method="POST">
        <input type="text" name="tarefa" placeholder="Nova Tarefa" required>
        <button type="submit">Adicionar</button>
    </form>

    <h3>Anotações</h3>
    <ul>
        <?php foreach ($anotacoes as $anotacao): ?>
            <li>
                <input type="checkbox" <?php echo $anotacao['concluida'] ? 'checked' : ''; ?>>
                <?php echo $anotacao['tarefa']; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <p><a href="logout.php">Sair</a></p>
</body>
</html>
