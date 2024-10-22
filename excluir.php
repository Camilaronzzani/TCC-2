<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);

    if (!empty($id_produto)) {
        try {
            // Excluir do estoque primeiro
            $query_estoque = "DELETE FROM tb_estoque WHERE id_produto = :id_produto";
            $stmt_estoque = $pdo->prepare($query_estoque);
            $stmt_estoque->bindParam(':id_produto', $id_produto);

            if ($stmt_estoque->execute()) {
                // Excluir o produto
                $query = "DELETE FROM tb_produtos WHERE id_produto = :id_produto";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':id_produto', $id_produto);

                if ($stmt->execute()) {
                    echo "Produto excluído com sucesso!";
                    header("Location: estoque.php");
                    exit;
                } else {
                    echo "Erro ao excluir o produto.";
                }
            } else {
                echo "Erro ao excluir o estoque do produto.";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        echo "Produto não encontrado.";
    }
}

