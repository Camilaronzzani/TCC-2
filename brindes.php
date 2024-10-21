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
    <h2 class="page-title">Assine o programa de Brindes</h2>
    <h3 class="page-descriptions">Você assina uma vez e recebe um brinde novo todo mês!</h3>
    <div class="brindes-grid">

    <?php
        $query = "SELECT * FROM tb_brindes ORDER BY data_cadastro DESC LIMIT 3";
        $res = $pdo->query($query);
        $brindes = $res->fetchAll();
        foreach ($brindes as $brinde){
      ?>
        <div class="brindes-item" onclick="openModal('modal<?php echo $brinde['id_brinde'] ?>')" >
          <h4 class="color-black"> <?php echo $brinde['nome'] ?></h4>
          <p class="price">R$ <?php echo $brinde['preco'] ?><del></del>R$ <?php echo ($brinde['preco'] - $brinde['preco'] * $brinde['desconto']) ?></p>
        </div>
    <?php } ?>
    </div>

    <?php 
      foreach ($brindes as $brinde){
    ?>
      <div id="modal<?php echo $brinde['id_brinde'] ?>" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeModal('modal<?php echo $brinde['id_brinde'] ?>')">&times;</span>
          <h3><?php echo $brinde['nome'] ?></h3>
          <p>Detalhes de pagamento:</p>
          <p>Valor: R$ <?php echo ($brinde['preco'] - $brinde['preco'] * $brinde['desconto']) ?></p>
          <p>Parcelas: Até 3x sem juros</p>
          <button>Selecionar</button>
        </div>
      </div>
    <?php 
      }
    ?>
  </main>

  <footer>
    <?php include "footer.php" ?>
  </footer>
</body>
<script>
// Função para abrir o modal
function openModal(modalId) {
  document.getElementById(modalId).style.display = "block";
}

// Função para fechar o modal
function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none";
}
</script>
</html>
