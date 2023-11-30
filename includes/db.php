<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'users';

$conexao = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conexao->connect_error) {
    die('Erro de conexão: ' . $conexao->connect_error);
}
?>