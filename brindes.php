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
        $stmt = $pdo->prepare($query);
        $brindes = $res->fetchAll();
        $stmt->execute();
        $produtos = $stmt->fetchAll();
        foreach ($brindes as $brinde){
      ?>
        <div class="brindes-item <?php echo ($_SESSION['id_brinde'] == $brinde['id_brinde'])?'selecionado':''; ?>" onclick="openModal('modal<?php echo $brinde['id_brinde'] ?>')" >
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
        <form action="brindes.php" method="POST">
          <span class="close" onclick="closeModal('modal<?php echo $brinde['id_brinde'] ?>')">&times;</span>
          <h3><?php echo $brinde['nome'] ?></h3>
          <p>Detalhes de pagamento:</p>
          <p>Valor: R$ <?php echo ($brinde['preco'] - $brinde['preco'] * $brinde['desconto']) ?></p>
          <p>Parcelas: Até 3x sem juros</p>
          <input type="hidden" name="id_brinde" value="<?php echo $brinde['id_brinde']?>">
          <div>Cartão de crédito:<input name="credit_card" id='credit_card' type='text'/></div>

          <?php if( $_SESSION['id_cliente']){?>
            <button class="mt-2">Selecionar</button>
          <?php }else{?>
            <p>Logue para selecionar o metodo de assinatura</p>
          <?php }?>
        </form>
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

<?php
session_start();
require_once 'conexao.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $credit_card = filter_input(INPUT_POST, 'credit_card', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id_brinde = filter_input(INPUT_POST, 'id_brinde', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!empty($credit_card) && !empty($id_brinde)) {
        try {
            $pdo->beginTransaction();
            $query_brinde = "UPDATE tb_clientes SET id_brinde = :id_brinde where id_cliente = :id_cliente";
            $stmt = $pdo->prepare($query_brinde);
            $stmt->bindParam(':id_brinde', $id_brinde);
            $stmt->bindParam(':id_cliente', $_SESSION['id_cliente']);
            if ($stmt->execute()) {
              $_SESSION['id_brinde'] = $id_brinde;
              $pdo->commit();
              echo "Brinde vinculado com sucesso!";
              header("Location: brindes.php");
              exit;
            } else {
              $pdo->rollBack();
              echo "Erro ao vincular o brinde.";
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "Erro: " . $e->getMessage();
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
?>