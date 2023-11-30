<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Bem-vindo ao Dashboard</h2>
        <p><a href="logout.php">Sair</a></p>
    </div>
</body>
</html>