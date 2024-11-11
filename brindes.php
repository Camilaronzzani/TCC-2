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
      session_start();
      require_once 'conexao.php';

      $query = "SELECT * FROM tb_brindes ORDER BY data_cadastro DESC LIMIT 3";
      $stmt = $pdo->prepare($query);
      $stmt->execute(); 
      $brindes = $stmt->fetchAll(); 

      foreach ($brindes as $brinde) {
          $desconto = 0.10;
          $precoComDesconto = $brinde['preco'] * (1 - $desconto);
      ?>
        <div class="brindes-item <?php echo (isset($_SESSION['id_brinde']) && $_SESSION['id_brinde'] == $brinde['id_brinde']) ? 'selecionado' : ''; ?>" 
             onclick="openModal('modal<?php echo $brinde['id_brinde'] ?>')">
          <h4 class="color-black"><?php echo htmlspecialchars($brinde['nome']); ?></h4>
          <p class="price">R$ <?php echo number_format($brinde['preco'], 2, ',', '.'); ?> 
            <del></del> R$ <?php echo number_format($precoComDesconto, 2, ',', '.'); ?>
          </p>
        </div>
      <?php } ?>
    </div>

    <?php
    foreach ($brindes as $brinde) {
        $precoComDesconto = $brinde['preco'] * (1 - $desconto);
    ?>
      <div id="modal<?php echo $brinde['id_brinde'] ?>" class="modal">
        <div class="modal-content">
          <form action="brindes.php" method="POST">
            <span class="close" onclick="closeModal('modal<?php echo $brinde['id_brinde'] ?>')">&times;</span>
            <h3><?php echo htmlspecialchars($brinde['nome']); ?></h3>
            <p>Detalhes de pagamento:</p>
            <p>Valor: R$ <?php echo number_format($precoComDesconto, 2, ',', '.'); ?></p>
            <p>Parcelas: Até 3x sem juros</p>
            <input type="hidden" name="id_brinde" value="<?php echo $brinde['id_brinde'] ?>">
            <div>Cartão de crédito: <input name="credit_card" id="credit_card" type="text" required /></div>

            <?php if (isset($_SESSION['id_cliente'])) { ?>
              <button class="mt-2" type="submit">Selecionar</button>
            <?php } else { ?>
              <p>Por favor, faça login para selecionar o método de assinatura.</p>
            <?php } ?>
          </form>
        </div>
      </div>
    <?php } ?>
  </main>

  <footer>
    <?php include "footer.php"; ?>
  </footer>

  <script>
    function openModal(modalId) {
      document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
      document.getElementById(modalId).style.display = "none";
    }
  </script>

</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'conexao.php';
    $credit_card = filter_input(INPUT_POST, 'credit_card', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id_brinde = filter_input(INPUT_POST, 'id_brinde', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!empty($credit_card) && !empty($id_brinde) && isset($_SESSION['id_cliente'])) {
        try {
            $pdo->beginTransaction();
            $query_brinde = "UPDATE tb_clientes SET id_brinde = :id_brinde WHERE id_cliente = :id_cliente";
            $stmt = $pdo->prepare($query_brinde);
            $stmt->bindParam(':id_brinde', $id_brinde, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente', $_SESSION['id_cliente'], PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                $_SESSION['id_brinde'] = $id_brinde;
                $pdo->commit();
                echo "<script>alert('Agora você é um assinante!');</script>";
                header("Location: brindes.php");
                exit;
            } else {
                $pdo->rollBack();
                echo "<script>alert('Erro ao vincular o brinde.');</script>";
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "Erro: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos e faça login.');</script>";
    }
}
?>
