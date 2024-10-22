<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $tamanho = filter_input(INPUT_POST, 'tamanho', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cor = filter_input(INPUT_POST, 'cor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);

    if (!empty($id_produto) && !empty($nome) && !empty($descricao) && !empty($preco) && !empty($tamanho) && !empty($cor) && !empty($marca) && !empty($quantidade)) {
        try {
            $query = "UPDATE tb_produtos SET nome = :nome, descricao = :descricao, preco = :preco, tamanho = :tamanho, cor = :cor, marca = :marca WHERE id_produto = :id_produto";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':tamanho', $tamanho);
            $stmt->bindParam(':cor', $cor);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':id_produto', $id_produto);

            if ($stmt->execute()) {
                $query_estoque = "UPDATE tb_estoque SET quantidade = :quantidade WHERE id_produto = :id_produto";
                $stmt_estoque = $pdo->prepare($query_estoque);
                $stmt_estoque->bindParam(':quantidade', $quantidade);
                $stmt_estoque->bindParam(':id_produto', $id_produto);

                if ($stmt_estoque->execute()) {
                    echo "Produto atualizado com sucesso!";
                    header("Location: estoque.php");
                    exit;
                } else {
                    echo "Erro ao atualizar o estoque.";
                }
            } else {
                echo "Erro ao atualizar o produto.";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
