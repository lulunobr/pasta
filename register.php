<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (login, senha) VALUES (:login, :senha)");
    if ($stmt->execute(['login' => $login, 'senha' => $senha])) {
        header('Location: index.php');
        exit;
    } else {
        $erro = "Erro ao registrar. Login já existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Registrar</h2>
    <form method="POST">
        <input type="text" name="login" placeholder="Login" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Registrar</button>
    </form>
    <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
    <p><a href="index.php">Voltar para Login</a></p>
</body>
</html>
