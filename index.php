<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <title>RM Sports</title>
</head>
<body>
  <header class="">
    <!-- Navbar -->
    <?php include "nav.php" ?>
  </header>
  <main>
    <div class="product-grid">
      <?php
        $query = "SELECT * FROM tb_produtos ORDER BY data_cadastro DESC LIMIT 8";
        $res = $pdo->query($query);
        $produtos = $res->fetchAll();
        var_dump($produtos);
        foreach ($produtos as $produto){
      ?>
        <div class="product-item">
          <img src="https://via.placeholder.com/250x250" alt="Chuteira Flexível Campo Predator Club">
          <h4>R$ <?php echo $produto['preco'] ?></h4>
          <p><?php echo $produto['nome'] ?></p>
          <p><?php echo $produto['marca'] ?>, <?php echo $produto['cor'] ?>, <?php echo $produto['tamanho'] ?></p>
        </div>
      <?php } ?>
      <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
    </div>
  </main>
  <footer>
    <?php include "footer.php" ?>
  </footer>
</body>
</html>