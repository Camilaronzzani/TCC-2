<?php
include_once 'conexao.php';

// Recebe os dados JSON do cliente
$dados = json_decode(file_get_contents('php://input'), true);
$produtos = [];

if ($dados) {
    foreach ($dados as $item) {
        $produtoId = $item['id'];
        $quantidade = $item['quantidade'];

        // Consulta o produto no banco de dados
        $query = "SELECT * FROM tb_produtos WHERE id_produto = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $produtoId);
        $stmt->execute();

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($produto) {
            // Adiciona o produto e a quantidade ao array de produtos
            $produto['quantidade'] = $quantidade;
            $produto['total'] = $quantidade * $produto['preco'];
            $produtos[] = $produto;
        }
    }
}

// Retorna os produtos como JSON
echo json_encode($produtos);
?>