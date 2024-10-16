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
