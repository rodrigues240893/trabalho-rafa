<?php
$servidor = "localhost:7306";
$usuario  = "root";
$senha    = "";
$bd       = "cliente";

// Conexão
$conexao = mysqli_connect($servidor, $usuario, $senha, $bd);

if (!$conexao) {
    die("Erro ao conectar ao banco: " . mysqli_connect_error());
}

// RECEBE OS DADOS DO FORMULÁRIO
$usuarioForm = $_POST['usuario'] ?? '';
$senhaForm = $_POST['senha'] ?? '';
$confirmaSenha = $_POST['confirmasenha'] ?? '';

// VERIFICA SE AS SENHAS CONFEREM
if ($senhaForm !== $confirmaSenha) {
    die("As senhas não conferem!");
}

// VERIFICA SE O USUÁRIO JÁ EXISTE
$sqlVerifica = "SELECT usuario FROM cliente WHERE usuario = '$usuarioForm'";
$resultado = mysqli_query($conexao, $sqlVerifica);

if (!$resultado) {
    die("Erro na consulta SQL: " . mysqli_error($conexao));
}

if (mysqli_num_rows($resultado) > 0) {
    die("Usuário já cadastrado!");
}

// GERA HASH DA SENHA
$senhaHash = hash("sha256",$senhaForm);

// INSERE NO BANCO
$sql = "INSERT INTO cliente (usuario, senha) VALUES ('$usuarioForm', '$senhaHash')";

if (mysqli_query($conexao, $sql)) {
    echo "Usuário cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . mysqli_error($conexao);
}
?>
