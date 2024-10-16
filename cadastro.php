<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>RM Sports - Cadastro</title>
</head>
<body>
  <header>
    <!-- Navbar -->
    <?php include "nav.php"; ?>
  </header>
  <main>
    <div class="login-container">
      <div class="container">
        <h2>Cadastro</h2>
        <form action="cadastro.php" method="POST">
          <div class="input-row">
            <div class="input-group">
              <label for="nome">Nome:</label>
              <input type="text" id="nome" name="nome" required>
            </div>
            <div class="input-group">
              <label for="telefone">Telefone:</label>
              <input type="text" id="telefone" name="telefone" required>
            </div>
          </div>
          <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="input-group">
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
          </div>
          <button type="submit">Cadastrar</button>
        </form>
        <p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
      </div>
    </div>
  </main>
  <footer>
    <?php include "footer.php"; ?>
  </footer>
</body>
</html>

<?php
    session_start();
    require_once 'conexao.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!empty($nome) && !empty($email) && !empty($telefone) && !empty($password) ) {

            $query = "SELECT * FROM tb_clientes WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                $senhaCriptografada = password_hash($password, PASSWORD_DEFAULT);

                $query = "INSERT INTO tb_clientes (nome, email, telefone, senha, data_cadastro) 
                          VALUES (:nome, :email, :telefone, :senha, CURDATE())";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':telefone', $telefone);
                $stmt->bindParam(':senha', $senhaCriptografada);

                if ($stmt->execute()) {
                    echo "Cadastro realizado com sucesso!";
                    header("Location: login.php");
                    exit;
                } else {
                    $erro = "Erro ao cadastrar o usuário. Tente novamente.";
                }
            } else {
                $erro = "O e-mail já está cadastrado!";
            }
    } else {
          $erro = "Por favor, preencha todos os campos.";
      }
  }
  if (isset($erro)) {
  echo "<p style='color:red;'>$erro</p>";
  }
?>
