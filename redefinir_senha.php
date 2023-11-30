<?php 
session_start();
require_once('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar se o token é válido
    $sql = "SELECT * FROM usuarios WHERE token_recuperacao = '$token'";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 1) {
        $_SESSION['token_recuperacao'] = $token;
    } else {
        $_SESSION['token_invalido'] = true;
        header('Location: login.php');
        exit();
    }
} else {
    // Se não tiver token na URL, redirecione para a página de login
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nova_senha = $_POST['nova_senha'];
    $hashed_nova_senha = password_hash($nova_senha, PASSWORD_DEFAULT);
    $token = $_SESSION['token_recuperacao'];

    // Atualize a senha no banco de dados e remova o token de recuperação
    $sql_update_senha = "UPDATE usuarios SET senha = '$hashed_nova_senha', token_recuperacao = NULL WHERE token_recuperacao = '$token'";
    $conexao->query($sql_update_senha);

    $_SESSION['senha_redefinida'] = true;
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Redefinir Senha</h2>

        <?php if (isset($_SESSION['token_invalido']) && $_SESSION['token_invalido']): ?>
            <p class="erro">Token de recuperação inválido</p>
        <?php endif; ?>

        <form action="redefinir_senha.php" method="post">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" name="nova_senha" id="nova_senha" required>

            <button type="submit">Redefinir Senha</button>
        </form>
    </div>
</body>
</html>

