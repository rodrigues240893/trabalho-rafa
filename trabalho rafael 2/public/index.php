<?php
// public/index.php
require __DIR__ . '/../src/session.php';
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mini Site - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card mx-auto" style="max-width:720px">
      <div class="card-body">
        <h1 class="card-title">Mini Site com Login</h1>
        <p class="card-text">Exemplo simples: registro, login (com hash), sessão e MySQL.</p>
        <a class="btn btn-primary" href="/register.php">Criar Conta</a>
        <a class="btn btn-outline-primary" href="/login.php">Entrar</a>
        <?php if (is_logged_in()): ?>
          <a class="btn btn-success" href="/dashboard.php">Ir para Dashboard</a>
          <a class="btn btn-danger" href="/logout.php">Sair</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
