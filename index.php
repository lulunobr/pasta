<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE login = :login");
    $stmt->execute(['login' => $login]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        $erro = "Login ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Tela de Login</h2>
    <form method="POST">
        <input type="text" name="login" placeholder="Login" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
    <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
    <p><a href="register.php">Registrar</a></p>
</body>
</html>
