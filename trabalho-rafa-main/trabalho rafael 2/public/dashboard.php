<?php
require __DIR__ . '/../src/session.php';
require_login();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card mx-auto" style="max-width:720px">
      <div class="card-body">
        <h1 class="card-title">Olá, <?=htmlspecialchars($_SESSION['user_email'])?></h1>
        <p class="card-text">Você está logado. Esta é uma exibição individual.</p>
        <a class="btn btn-danger" href="/logout.php">Sair</a>
      </div>
    </div>
  </div>
</body>
</html>
