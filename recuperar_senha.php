<?php
session_start();
require_once('includes/db.php');
require_once('enviar_email.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows === 1) {
        // Gere um token de recuperação de senha e armazene no banco de dados
        $token = bin2hex(random_bytes(32));
        $sql_update_token = "UPDATE usuarios SET token_recuperacao = '$token' WHERE email = '$email'";
        $conexao->query($sql_update_token);

        // Envie um e-mail com o link de recuperação contendo o token
        $assunto = 'Recuperação de Senha';
        $mensagem = "Olá,\n\nVocê solicitou a recuperação de senha. Clique no link abaixo para redefinir sua senha:\n\n";
        $mensagem .= "http://localhost/redefinir_senha.php?token=$token\n\n";
        $mensagem .= "Se você não solicitou essa recuperação, ignore este e-mail.";

        // Substitua "seuemail@dominio.com" pelo seu endereço de e-mail
        $remetente = 'joao.miguel@acrie.com.br';
        mail($email, $assunto, $mensagem, 'From: ' . $remetente);

        $_SESSION['recuperacao_sucesso'] = true;
        header('Location: login.php');
        exit();
    } else {
        $erro_recuperacao = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recuperação de Senha</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h2>Recuperação de Senha</h2>

    <?php if (isset($erro_recuperacao) && $erro_recuperacao): ?>
        <p class="erro">E-mail não encontrado.</p>
    <?php endif; ?>

    <form action="enviar_email.php" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Recuperar Senha</button>
    </form>
</div>

</body>
</html>
