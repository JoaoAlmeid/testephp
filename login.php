<?php
session_start();
require_once('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows === 1) {
        $_SESSION['logged_in'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        $erro_login = true;
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

<div class="container">
    <h2>Login</h2>

    <?php if (isset($erro_login) && $erro_login): ?>
        <p class="erro">E-mail ou senha incorretos.</p>
    <?php endif; ?>

    <form action="login.php" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Entrar</button>

        <p>Esqueçeu a senha? <a href="recuperar_senha.php">Recupere aqui</a></p>
        <p>Ainda não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
    </form>
</div>

</body>
</html>