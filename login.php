<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>RM Sports - Login</title>
</head>
<body>
  <header>
    <!-- Navbar -->
    <?php include "nav.php"; ?>
  </header>
  <main>
    <div class="login-container">
      <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
          <div class="input-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
          </div>
          <div class="input-group">
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
          </div>
          <button type="submit">Entrar</button>
        </form>
        <p>Não tem cadastro? <a href="cadastro.php">Cadastre-se aqui</a></p> 
      </div>
    </div>
  </main>
  <footer>
    <?php include "footer.php" ?>
  </footer>
</body>
</html>

<?php

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM tb_clientes WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['senha'])) {
            $_SESSION['id_cliente'] = $usuario['id_cliente'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['id_brinde'] = $usuario['id_brinde'];

            header("Location: index.php");
            exit;
        } else {
            $erro = "E-mail ou senha incorretos!";
        }
    } else {
        $erro = "Por favor, pre todos os campos.";        
    }
}

if (isset($erro)) {
    echo "<p style='color:red;'>$erro</p>";
}
?>
