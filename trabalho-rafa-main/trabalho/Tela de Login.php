<?php
// tela_login.php - Tela de LOGIN feita com o mesmo estilo do seu index.html
session_start();

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && strlen($_POST['usuario'])>0){
    $usuario = $_POST['usuario'] ?? '';
    $senha   = $_POST['senha'] ?? '';

    // conexão com banco
    $servidor = "localhost:7306";
    $userdb   = "root";
    $senhabd  = "";
    $bd       = "cliente";

    $con = mysqli_connect($servidor, $userdb, $senhabd, $bd);

    if (!$con) {
        die("Erro ao conectar ao banco: " . mysqli_connect_error());
    }

    // busca o usuário
    $sql = "SELECT * FROM cliente WHERE usuario = '$usuario' LIMIT 1";
    $res = mysqli_query($con, $sql);

    if ($res) {
        $dados = mysqli_fetch_assoc($res);
        $senhaInserida = hash("sha256",$senha);
        // VERIFICA SENHA (precisa estar hashada no banco)
        if ($senhaInserida === $dados['senha']) {
            //faz algo
            echo"foi";
        } else {
            $erro = "❌ Senha incorreta!".$senhaInserida." + ".$dados['senha'];
        }
    } else {
        $erro = "❌ Usuário não encontrado!". mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tela de Login</title>

<style>
body{
    background: linear-gradient(135deg, #6b6b6b, #a0a0a0);
    font-family: "Segoe UI", Arial, sans-serif;
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login{
    width: 380px;
    background: #044141;
    padding: 30px 25px;
    border-radius: 12px;
    text-align: center;
    color: white;
    box-shadow: 0px 8px 25px rgba(0,0,0,0.25);
    animation: fadeIn 0.8s ease;
}

h2{
    margin-bottom: 20px;
    font-size: 26px;
    font-weight: 700;
}

label{
    font-size: 18px;
    margin-bottom: 5px;
    display: block;
    text-align: left;
    padding-left: 25px;
}

input{
    padding: 12px;
    font-size: 16px;
    width: 85%;
    margin-bottom: 15px;
    border-radius: 6px;
    border: none;
    outline: none;
    transition: 0.3s;
}

input:focus{
    box-shadow: 0px 0px 8px rgba(0,255,255,0.7);
    transform: scale(1.03);
}

.botao{
    margin-top: 10px;
    width: 90%;
    padding: 13px;
    cursor: pointer;
    background: #000;
    color: #f2f2f2;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    font-weight: 600;
    transition: 0.3s ease;
}

.botao:hover{
    background-color: #0bc93a;
    transform: scale(1.05);
}

.erro{
    background:#ff4444;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    font-weight:bold;
}

/* Animação */
@keyframes fadeIn {
    0%{ opacity: 0; transform: translateY(20px); }
    100%{ opacity: 1; transform: translateY(0); }
}

</style>
</head>
<body>
    <div class="login">
        <h2>LOGIN</h2>

        <?php if ($erro): ?>
            <div class="erro"> <?= $erro ?> </div>
        <?php endif; ?>

        <form method="POST">

            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <input class="botao" type="submit" value="Entrar">

        </form>
    </div>
</body>
</html>