<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Cadastro de Produtos</title>
</head>
<body>
    <header>
        <?php include "nav.php"; ?>
    </header>
    <main>
        <div class="login-container">
            <div class="container">
                <h2>Cadastro de Produto</h2>
                <form action="produtos.php" method="post">
                    <div class="input-row">
                        <div>
                            <label for="nome">Nome do Produto:</label>
                            <input type="text" id="nome" name="nome">
                        </div>
                        <div>
                            <label for="preco">Preço:</label>
                            <input type="number" id="preco" name="preco">
                        </div>
                    </div>
                    <div class="input-row">
                        <div>
                            <label for="quantidade">Quantidade:</label>
                            <input type="number" id="quantidade" name="quantidade">
                        </div>
                        <div>
                            <label for="tamanho">Tamanho:</label>
                            <input type="text" id="tamanho" name="tamanho">
                        </div>
                    </div>
                    <div class="input-row">
                        <div>
                            <label for="cor">Cor:</label>
                            <input type="text" id="cor" name="cor">
                        </div>
                        <div>
                            <label for="marca">Marca:</label>
                            <select id="marca" name="marca">
                                <option value="Adidas">Adidas</option>
                                <option value="Nike">Nike</option>
                                <option value="Puma">Puma</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="descricao">Descrição:</label>
                        <textarea id="descricao" name="descricao"></textarea>
                    </div>
                    <button type="submit">Cadastrar Produto</button>
                </form>
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $tamanho = filter_input(INPUT_POST, 'tamanho', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cor = filter_input(INPUT_POST, 'cor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);

    if (!empty($nome) && !empty($descricao) && !empty($preco) && !empty($tamanho) && !empty($cor) && !empty($marca) && !empty($quantidade)) {
        try {
            $pdo->beginTransaction();
            $query_produto = "INSERT INTO tb_produtos (nome, descricao, preco, tamanho, cor, marca, data_cadastro) 
                              VALUES (:nome, :descricao, :preco, :tamanho, :cor, :marca, NOW())";
            $stmt = $pdo->prepare($query_produto);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':tamanho', $tamanho);
            $stmt->bindParam(':cor', $cor);
            $stmt->bindParam(':marca', $marca);

            if ($stmt->execute()) {
                $id_produto = $pdo->lastInsertId();

                $query_estoque = "INSERT INTO tb_estoque (id_produto, quantidade, tipo_movimentacao) 
                                  VALUES (:id_produto, :quantidade, 'entrada')";
                $stmt_estoque = $pdo->prepare($query_estoque);
                $stmt_estoque->bindParam(':id_produto', $id_produto);
                $stmt_estoque->bindParam(':quantidade', $quantidade);

                if ($stmt_estoque->execute()) {
                    $pdo->commit();
                    echo "Produto e estoque cadastrados com sucesso!";
                    header("Location: produtos.php");
                    exit;
                } else {
                    $pdo->rollBack();
                    echo "Erro ao cadastrar no estoque.";
                }
            } else {
                $pdo->rollBack();
                echo "Erro ao cadastrar o produto.";
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