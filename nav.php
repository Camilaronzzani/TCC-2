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
        </div>
      </div>
    <?php } else { ?>
      <a href="login.php">Entrar</a>
    <?php } ?>
    <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/126/126510.png" alt="Carrinho"></a>
  </div>
</nav>