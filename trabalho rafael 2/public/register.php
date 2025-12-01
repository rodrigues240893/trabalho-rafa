<?php
require __DIR__ . '/../src/db.php';
require __DIR__ . '/../src/session.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha'] ?? '');

    if (!$email) {
        $errors[] = 'Email inválido.';
    }
    if (strlen($senha) < 6) {
        $errors[] = 'Senha deve ter pelo menos 6 caracteres.';
    }

    if (empty($errors)) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare('INSERT INTO users (email, password_hash) VALUES (?, ?)');
            $stmt->execute([$email, $hash]);
            $success = 'Conta criada com sucesso! Você pode fazer login.';
        } catch (PDOException $e) {
            // se for duplicata de email, throw error amigável
            if ($e->getCode() == 23000) {
                $errors[] = 'Email já cadastrado.';
            } else {
                $errors[] = 'Erro ao cadastrar (ver logs).';
            }
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Criar Conta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card mx-auto" style="max-width:540px">
      <div class="card-body">
        <h2 class="card-title">Cadastro</h2>

        <?php if ($errors): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach($errors as $err) echo "<li>".htmlspecialchars($err)."</li>"; ?>
            </ul>
          </div>
        <?php endif; ?>

        <?php if ($success): ?>
          <div class="alert alert-success"><?=htmlspecialchars($success)?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Senha</label>
            <input class="form-control" type="password" name="senha" required>
            <div class="form-text">Mínimo 6 caracteres.</div>
          </div>
          <button class="btn btn-primary" type="submit">Criar Conta</button>
          <a class="btn btn-link" href="/login.php">Já tenho conta</a>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
