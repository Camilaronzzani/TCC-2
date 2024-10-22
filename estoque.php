<?php
require_once 'conexao.php';
$query = "SELECT * from tb_estoque inner join tb_produtos on tb_produtos.id_produto = tb_estoque.id_produto";
$stmt = $pdo->prepare($query);
$stmt->execute();
$tenis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
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
        <?php include "nav.php" ?>
    </header>
    <main>
        <div class="center">
            <h1>Estoque de Tênis</h1>
        </div>
        <div class="botao_estoque">
            <button id="addTenisBtn">Adicionar Tênis</button>
        </div>

        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Marca</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tenis as $item): ?>
                    <tr>
                        <td><?= $item['id_estoque'] ?></td>
                        <td><?= $item['nome'] ?></td>
                        <td><?= $item['marca'] ?></td>
                        <td><?= $item['quantidade'] ?></td>
                        <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($item['quantidade'] * $item['preco'], 2, ',', '.') ?></td>
                        <td>
                            <button class="editBtn" data-id="<?= $item['id_estoque'] ?>" data-nome="<?= $item['nome'] ?>" data-marca="<?= $item['marca'] ?>" data-quantidade="<?= $item['quantidade'] ?>" data-preco="<?= $item['preco'] ?>">Editar</button>
                            <button class="deleteBtn" data-id="<?= $item['id_estoque'] ?>">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <?php include "footer.php" ?>
    </footer>
    <div id="addModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Adicionar Novo Tênis</h2>
            <form action="estoque.php" method="POST" enctype="multipart/form-data">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required><br>

                <label for="marca">Marca:</label>
                <select id="marca" name="marca">
                    <option value="Adidas">Adidas</option>
                    <option value="Nike">Nike</option>
                    <option value="Puma">Puma</option>
                </select>

                <label for="tamanho">Tamanho:</label>
                <input type="text" id="tamanho" name="tamanho">

                <label for="cor">Cor:</label>
                <input type="text" id="cor" name="cor">

                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required><br>

                <label for="preco">Preço:</label>
                <input type="number" id="preco" name="preco" required><br>

                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao"></input>

                <label for="imagem">Imagem:</label>
                <input type="file" id="imagem" name="imagem" required><br>
                <button type="submit">Adicionar</button>
            </form>
        </div>
    </div>

    <!-- Modal Editar Produto -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <form id="editForm" action="editar.php" method="POST">
                <input type="hidden" id="edit-id" name="id_produto">
                <label for="edit-nome">Nome:</label>
                <input type="text" id="edit-nome" name="nome" required><br>

                <label for="edit-descricao">Descrição:</label>
                <input type="text" id="edit-descricao" name="descricao" required><br>

                <label for="edit-preco">Preço:</label>
                <input type="text" id="edit-preco" name="preco" required><br>

                <label for="edit-tamanho">Tamanho:</label>
                <input type="text" id="edit-tamanho" name="tamanho" required><br>

                <label for="edit-cor">Cor:</label>
                <input type="text" id="edit-cor" name="cor" required><br>

                <label for="edit-marca">Marca:</label>
                <input type="text" id="edit-marca" name="marca" required><br>

                <label for="edit-quantidade">Quantidade:</label>
                <input type="number" id="edit-quantidade" name="quantidade" required><br>

                <button type="submit" action="editar.php">Salvar Alterações</button>
                <button type="button" onclick="closeModal('editModal')">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Modal Excluir Produto -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <form id="deleteForm" action="excluir.php" method="POST">
                <input type="hidden" id="delete-id" name="id_produto">
                <p>Tem certeza que deseja excluir este produto?</p>
                <button type="submit">Sim, Excluir</button>
                <button type="button" onclick="closeModal('deleteModal')">Cancelar</button>
            </form>
        </div>
    </div>
</body>

</html>

<script>
    var addModal = document.getElementById('addModal');
    var addTenisBtn = document.getElementById('addTenisBtn');
    var closeButtons = document.getElementsByClassName('close');

    addTenisBtn.onclick = function() {
        addModal.style.display = 'block';
    }

    Array.from(closeButtons).forEach(function(element) {
        element.onclick = function() {
            element.closest('.modal').style.display = 'none';
        }
    });

    window.onclick = function(event) {
        if (event.target == addModal) {
            addModal.style.display = 'none';
        }
    }

    const editButtons = document.querySelectorAll('.editBtn');
    const editModal = document.getElementById('editModal');

    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('edit-id').value = this.dataset.id;
            document.getElementById('edit-nome').value = this.dataset.nome;
            document.getElementById('edit-descricao').value = this.dataset.descricao;
            document.getElementById('edit-preco').value = this.dataset.preco;
            document.getElementById('edit-tamanho').value = this.dataset.tamanho;
            document.getElementById('edit-cor').value = this.dataset.cor;
            document.getElementById('edit-marca').value = this.dataset.marca;
            document.getElementById('edit-quantidade').value = this.dataset.quantidade;

            document.getElementById('editModal').style.display = 'block';
        });
    });

    document.querySelectorAll('.deleteBtn').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('delete-id').value = this.dataset.id;
            document.getElementById('deleteModal').style.display = 'block';
        });
    });

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
</script>
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

    $imagem = $_FILES['imagem'];
    $imagemNome = null;

    function uploadImagem($imagem)
    {
        if ($imagem && $imagem['error'] == 0) {
            $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
            $imagemNome = uniqid("img_") . "." . $extensao;
            $imagemCaminho = "/var/www/html/TCC-2/imagens/produtos/" . $imagemNome;

            if (move_uploaded_file($imagem['tmp_name'], $imagemCaminho)) {
                return $imagemNome;
            } else {
                throw new Exception("Erro ao fazer upload da imagem.");
            }
        } else {
            throw new Exception("Erro ao enviar a imagem: " . $imagem['error']);
        }
    }

    try {
        $imagemNome = uploadImagem($imagem);

        if (!empty($nome) && !empty($descricao) && !empty($preco) && !empty($tamanho) && !empty($cor) && !empty($marca) && !empty($quantidade)) {
            $pdo->beginTransaction();

            $query_produto = "INSERT INTO tb_produtos (nome, descricao, preco, tamanho, cor, marca, imagem, data_cadastro) 
                              VALUES (:nome, :descricao, :preco, :tamanho, :cor, :marca, :imagem, NOW())";
            $stmt = $pdo->prepare($query_produto);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':tamanho', $tamanho);
            $stmt->bindParam(':cor', $cor);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':imagem', $imagemNome);

            if ($stmt->execute()) {
                $id_produto = $pdo->lastInsertId();

                $query_estoque = "INSERT INTO tb_estoque (id_produto, quantidade, tipo_movimentacao) 
                                  VALUES (:id_produto, :quantidade, 'entrada')";
                $stmt_estoque = $pdo->prepare($query_estoque);
                $stmt_estoque->bindParam(':id_produto', $id_produto);
                $stmt_estoque->bindParam(':quantidade', $quantidade);

                if ($stmt_estoque->execute()) {
                    $pdo->commit();
                    // Redireciona para evitar reenvio
                    header("Location: estoque.php");
                    exit;
                } else {
                    $pdo->rollBack();
                    echo "Erro ao cadastrar no estoque.";
                }
            } else {
                $pdo->rollBack();
                echo "Erro ao cadastrar o produto.";
            }
        } else {
            echo "Por favor, preencha todos os campos.";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
        $pdo->rollBack();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Erro: " . $e->getMessage();
    }
}
?>