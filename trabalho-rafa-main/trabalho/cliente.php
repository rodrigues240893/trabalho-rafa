<?php
include("conexao.php");

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$confirmasenha = $_POST['confirmasenha'];

// IMPORTANTE: coloque sempre aspas nos valores
$sql = "INSERT INTO cliente (`usuario`, `senha`, `confirmasenha`) 
        VALUES ('$usuario', '$senha', '$confirmasenha')";

if (mysqli_query($conexao, $sql)) {
    echo "Usuário cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>
