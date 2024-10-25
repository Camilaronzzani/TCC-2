<?php include_once 'conexao.php'; ?>
<nav>
  <div class="nav-left">
    <a href="/">
      <img src="imagens/logo.png" alt="Logo">
    </a>
  </div>
  <div class="nav-center">
    <a href="index.php?marca=adidas">Adidas</a>
    <a href="index.php?marca=nike">Nike</a>
    <a href="index.php?marca=puma">Puma</a>
  </div>
  <div class="nav-right">
    <?php if (isset($_SESSION['nome'])) { ?>
      <a href="brindes.php">Brindes</a>
      <?php if ($_SESSION['id_cliente'] == 1) { ?>
        <a href="estoque.php">Estoque</a>
      <?php } ?>
      <div class="dropdown">
        <button class="dropbtn"><?php echo htmlspecialchars($_SESSION['nome']); ?></button>
        <div class="dropdown-content">
          <a href="logout.php">Logout</a>
          <a href="meus_pedidos.php">Meus Pedidos</a>
        </div>
      </div>
    <?php } else { ?>
      <a href="login.php">Entrar</a>
    <?php } ?>     
    <a href="comprar.php"><img src="https://cdn-icons-png.flaticon.com/512/126/126510.png" alt="Carrinho">(<span id="quanti-carrinho">0</span>)</a>
  </div>
</nav>

<script>

  // Carrega o carrinho do localStorage ou inicializa como um array vazio
  function carregarCarrinho() {
    const carrinho = localStorage.getItem('carrinho');
    return carrinho ? JSON.parse(carrinho) : [];
  }

  // Salva o carrinho no localStorage
  function salvarCarrinho(carrinho) {
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
  }
  
  document.addEventListener('DOMContentLoaded', () => {
    atualizarQuantidadeCarrinho();
  });

  function atualizarQuantidadeCarrinho() {
    const carrinho = carregarCarrinho();
    const quantidadeTotal = carrinho.reduce((total, item) => total + item.quantidade, 0);

    // Atualiza o link da navbar com a quantidade de itens no carrinho
    document.getElementById('quanti-carrinho').textContent = quantidadeTotal;
  }
</script>