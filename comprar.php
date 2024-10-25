<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>Finalizar Compra - RM Sports</title>
</head>

<body>
  <header>
    <!-- Navbar -->
    <?php include "nav.php"; ?>
  </header>

  <main class="container-fluid">
    <h2>Finalizar Compra</h2>

    <div class="carrinho-review">
      <h3>Seu Carrinho</h3>
      <div class="product-grid" id="product-grid">
        <div class="buy-product-item">
        </div>
      </div>
      <div class="total">
        <h4>Total: R$ <span id="total"></span></h4>
      </div>
    </div>

    <div class="checkout-form">
      <h3>Informações de Pagamento e Envio</h3>

      <form action="comprar.php" method="POST" id="form">
        <input type="hidden" name="id_cliente" value="<?php echo $_SESSION['id_cliente'] ?>" />
        <input type="hidden" name="carrinho" id="carrinho-input">
        <!-- Informações de Envio -->
        <div class="input-group">
          <label for="nome">Nome Completo</label>
          <input type="text" id="nome" name="nome" required>
        </div>

        <div class="input-group">
          <label for="endereco">Endereço</label>
          <input type="text" id="endereco" name="endereco" required>
        </div>

        <div class="input-group">
          <label for="cidade">Cidade</label>
          <input type="text" id="cidade" name="cidade" required>
        </div>

        <div class="input-row">
          <div class="input-group">
            <label for="cep">CEP</label>
            <input type="text" id="cep" name="cep" required>
          </div>

          <div class="input-group">
            <label for="estado">Estado</label>
            <input type="text" id="estado" name="estado" required>
          </div>
        </div>

        <!-- Informações de Pagamento -->
        <h4>Informações de Pagamento</h4>

        <div class="input-group">
          <label for="cartao-numero">Número do Cartão</label>
          <input type="text" id="cartao-numero" name="cartao-numero" required>
        </div>

        <div class="input-row">
          <div class="input-group">
            <label for="cartao-expiracao">Data de Expiração</label>
            <input type="date" id="cartao-expiracao" name="cartao-expiracao" required>
          </div>

          <div class="input-group">
            <label for="cartao-cvv">CVV</label>
            <input type="text" id="cartao-cvv" name="cartao-cvv" required>
          </div>
        </div>

        <?php if ($_SESSION['id_cliente']) { ?>
          <button type="submit">Finalizar Compra</button>
        <?php } else { ?>
          <p>Faça o Login para comprar</p>
        <?php } ?>

      </form>
    </div>
  </main>

  <footer>
    <?php include "footer.php"; ?>
  </footer>

  <script>
    function removerDoCarrinho(produtoId) {
      const carrinho = carregarCarrinho();
      const itemIndex = carrinho.findIndex(item => item.id === produtoId);

      if (itemIndex !== -1) {
        if (carrinho[itemIndex].quantidade > 1) {
          // Reduz a quantidade se for maior que 1
          carrinho[itemIndex].quantidade -= 1;
        } else {
          // Remove o item completamente se a quantidade for 1
          carrinho.splice(itemIndex, 1);
        }

        salvarCarrinho(carrinho); // Atualiza o carrinho no localStorage
        atualizarQuantidadeCarrinho(); // Atualiza a quantidade exibida na interface

        alert('Produto removido do carrinho!');
      } else {
        alert('Produto não encontrado no carrinho.');
      }
      renderizarCarrinho();
    }

    document.getElementById('form').addEventListener('submit', function(event) {
      event.preventDefault(); // Previne o envio padrão para adicionar os dados do carrinho

      const carrinho = carregarCarrinho(); // Função que carrega o carrinho do localStorage

      // Serializa o carrinho para JSON e insere no campo oculto
      document.getElementById('carrinho-input').value = JSON.stringify(carrinho);

      // Agora, envia o formulário
      this.submit();
    });

    function renderizarCarrinho() {
      let carrinho = carregarCarrinho();
      if (carrinho.length > 0) {
        fetch('obter_produtos.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(carrinho),
          })
          .then(response => response.json())
          .then(produtos => {
            let html = '';
            produtos.forEach(produto => {
              html += `
                  <div class="buy-product-item">
                    <img src="/imagens/produtos/${produto.imagem}" alt="${produto.nome}" width="50">
                    <div class="product-details">
                      <h4>${produto.nome}</h4>
                      <p>R$ ${produto.preco}</p>
                      <p>Quantidade: ${produto.quantidade}</p>
                      <p>Total: R$ ${(produto.total).toFixed(2)}</p>
                    </div>
                    <button onclick="removerDoCarrinho(${produto.id_produto})">Remover</button>
                  </div>
                `;
            });
            document.getElementById('product-grid').innerHTML = html;
            document.getElementById('total').innerHTML = produtos.reduce((total, item) => total + item.total, 0);
          }).catch(error => {
            console.error('Erro ao carregar o carrinho:', error);
          });
      } else {
        alert('Seu carrinho está vazio.');
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
      renderizarCarrinho();
    });
  </script>
</body>

</html>
<?php
session_start();
require_once 'conexao.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Dados de envio e pagamento
  $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cartaoNumero = filter_input(INPUT_POST, 'cartao-numero', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cartaoExpiracao = filter_input(INPUT_POST, 'cartao-expiracao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cartaoCVV = filter_input(INPUT_POST, 'cartao-cvv', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Carrinho de compras
  $carrinho = json_decode($_POST['carrinho'], true);

  if (!empty($id_cliente) && !empty($nome) && !empty($endereco) && !empty($cidade) && !empty($cep) && !empty($estado) && !empty($carrinho)) {
    try {
      $pdo->beginTransaction();

      // 1. Inserir o pedido na tabela `tb_pedidos`
      $queryPedido = "INSERT INTO tb_vendas (id_cliente, nome, endereco, cidade, cep, estado, data_venda) 
                            VALUES (:id_cliente, :nome, :endereco, :cidade, :cep, :estado, NOW())";
      $stmtPedido = $pdo->prepare($queryPedido);
      $stmtPedido->bindParam(':id_cliente', $id_cliente);
      $stmtPedido->bindParam(':nome', $nome);
      $stmtPedido->bindParam(':endereco', $endereco);
      $stmtPedido->bindParam(':cidade', $cidade);
      $stmtPedido->bindParam(':cep', $cep);
      $stmtPedido->bindParam(':estado', $estado);
      $stmtPedido->execute();

      // Obter o ID do pedido recém-criado
      $pedidoId = $pdo->lastInsertId();

      // 2. Inserir os itens do pedido na tabela `tb_itens_pedido`
      $queryItem = "INSERT INTO tb_itens_vendas (id_venda, id_produto, quantidade, preco_unitario) 
                          VALUES (:id_pedido, :id_produto, :quantidade, :preco_unitario)";
      $stmtItem = $pdo->prepare($queryItem);

      foreach ($carrinho as $item) {
        $stmtItem->bindParam(':id_pedido', $pedidoId);
        $stmtItem->bindParam(':id_produto', $item['id']);
        $stmtItem->bindParam(':quantidade', $item['quantidade']);
        $stmtItem->bindParam(':preco_unitario', $item['preco_unitario']);
        $stmtItem->execute();

        // 3. Atualizar o estoque após inserir o item do pedido
        $queryEstoque = "UPDATE tb_estoque SET quantidade = quantidade - :quantidade WHERE id_produto = :id_produto";
        $stmtEstoque = $pdo->prepare($queryEstoque);
        $stmtEstoque->bindParam(':quantidade', $item['quantidade']);
        $stmtEstoque->bindParam(':id_produto', $item['id']);
        $stmtEstoque->execute();
      }

      $pdo->commit();

      echo "<script>window.location.href='pedido.php';</script>";
      exit();
    } catch (Exception $e) {
      $pdo->rollBack();
      echo "<p style='color:red;'>Erro ao finalizar a compra: " . $e->getMessage() . "</p>";
    }
  }
}
?>
