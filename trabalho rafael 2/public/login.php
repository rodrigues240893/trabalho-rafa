<?php
require __DIR__ . '/../src/db.php';
require __DIR__ . '/../src/session.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha'] ?? '');

    if (!$email || !$senha) {
        $errors[] = 'Preencha email e senha.';
    } else {
        $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['password_hash'])) {
            // sucesso: criar sessão
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $email;
            header('Location: /dashboard.php');
            exit;
        } else {
            $errors[] = 'Email ou senha incorretos.';
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card mx-auto" style="max-width:540px">
      <div class="card-body">
        <h2 class="card-title">Login</h2>

        <?php if ($errors): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach($errors as $err) echo "<li>".htmlspecialchars($err)."</li>"; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Senha</label>
            <input class="form-control" type="password" name="senha" required>
          </div>
          <button class="btn btn-primary" type="submit">Entrar</button>
          <a class="btn btn-link" href="/register.php">Criar conta</a>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
