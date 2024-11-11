<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>RM Sports</title>
</head>

<body>
  <header>
    <!-- Navbar -->
    <?php include "nav.php"; ?>
  </header>
  <main>
    <div class="product-grid">
      <?php
      include_once 'conexao.php';

      if (isset($_GET['marca'])) {
        $marca = $_GET['marca'];
        $query = "SELECT * FROM tb_produtos WHERE marca = :marca ORDER BY data_cadastro DESC LIMIT 8";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':marca', $marca);
      } else {
        $query = "SELECT * FROM tb_produtos ORDER BY data_cadastro DESC LIMIT 8";
        $stmt = $pdo->query($query);
      }

      $stmt->execute();
      $produtos = $stmt->fetchAll();

      foreach ($produtos as $produto) {
      ?>
        <div class="product-item">
          <a href="index.php?marca=<?php echo urlencode($produto['marca']); ?>">
            <img src="/imagens/produtos/<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
            <h4>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></h4>
            <p><?php echo htmlspecialchars($produto['nome']); ?></p>
            <p><?php echo htmlspecialchars($produto['marca']); ?>, <?php echo htmlspecialchars($produto['cor']); ?>, <?php echo htmlspecialchars($produto['tamanho']); ?></p>
          </a>

          <button onclick="comprarProduto(<?php echo $produto['id_produto']; ?>)">Comprar</button>
          <button onclick="adicionarAoCarrinho(<?php echo $produto['id_produto']; ?>, <?php echo $produto['preco']; ?>)">Adicionar ao Carrinho</button>
        </div>
      <?php } ?>
    </div>
  </main>
  <footer>
    <?php include "footer.php"; ?>
  </footer>

  <script>
    function comprarProduto(produtoId) {
      adicionarAoCarrinho(produtoId, null, false);
      window.location.href = 'comprar.php?id=' + produtoId;
    }

    function adicionarAoCarrinho(produtoId, preco, mostrarNotificacao = true) {
      const carrinho = carregarCarrinho();

      const itemExistente = carrinho.find(item => item.id === produtoId);

      if (itemExistente) {
        itemExistente.quantidade += 1;
      } else {
        const item = {
          id: produtoId,
          quantidade: 1,
          preco_unitario: preco
        };
        carrinho.push(item);
      }

      salvarCarrinho(carrinho);
      atualizarQuantidadeCarrinho();

      if (mostrarNotificacao) {
        const notification =  alert('Produto adicionado ao carrinho!');
        notification.style.display = 'block';
        notification.classList.remove('hidden');
        setTimeout(() => {
          notification.classList.add('hidden');
          setTimeout(() => {
            notification.style.display = 'none';
          }, 500);
        }, 2000);
      }
    }
  </script>
</body>

</html>