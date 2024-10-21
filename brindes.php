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
        <div class="brindes-item" onclick="openModal('modal1')" >
          <h4 class="color-black">Assinatura Mensal</h4>
          <p class="price"> R$ 184,95</p>
        </div>
        <div class="brindes-item">
          <h4 class="color-black">Assinatura Semestral</h4>
          <p class="price"><del>R$ 224,99</del> R$ 184,95</p>
        </div>
        <div class="brindes-item">
          <h4 class="color-black">Assinatura Anual</h4>
          <p class="price"><del>R$ 224,99</del> R$ 184,95</p>
        </div>
    </div>

    <!-- Modal para Assinatura Trimestral -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('modal1')">&times;</span>
      <h3>Assinatura Trimestral</h3>
      <p>Detalhes de pagamento:</p>
      <p>Valor: R$ 194,95</p>
      <p>Parcelas: Até 3x sem juros</p>
      <!-- Outros detalhes aqui -->
    </div>
  </div>

  <!-- Modal para Assinatura Semestral -->
  <div id="modal2" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('modal2')">&times;</span>
      <h3>Assinatura Semestral</h3>
      <p>Detalhes de pagamento:</p>
      <p>Valor: R$ 184,95</p>
      <p>Parcelas: Até 6x sem juros</p>
      <!-- Outros detalhes aqui -->
    </div>
  </div>
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
