<?php
    session_start();
    require_once('includes/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $hashed_senha = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$hashed_senha')";
        $resultado = $conexao->query($sql);

        if ($resultado) {
            $_SESSION['cadastro_sucesso'] = true;
            header('Location: login.php');
            exit();
        } else {
            $erro_cadastro = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>
        <?php if (isset($erro_cadastro) && $erro_cadastro): ?>
            <p class="erro">Erro ao Cadastrar. Tente novamente</p>
        <?php endif; ?>

        <form action="cadastro.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>