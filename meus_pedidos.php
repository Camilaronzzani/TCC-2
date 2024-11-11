<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id_cliente'])) {
    header('Location: login.php');
    exit();
}

$id_cliente = $_SESSION['id_cliente'];

$stmt = $pdo->prepare("SELECT * FROM tb_vendas WHERE id_cliente = :id_cliente");
$stmt->execute(['id_cliente' => $id_cliente]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Meus Pedidos</title>
</head>

<body>
    <header>
        <!-- Navbar -->
        <?php include "nav.php"; ?>
    </header>
    <?php if (empty($pedidos)): ?>
        <p>Você ainda não fez nenhum pedido.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID do Pedido</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Cidade</th>
                    <th>CEP</th>
                    <th>Estado</th>
                    <th>Data do Pedido</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo $pedido['id_venda']; ?></td>
                        <td><?php echo htmlspecialchars(html_entity_decode($pedido['nome'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars(html_entity_decode($pedido['endereco'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars(html_entity_decode($pedido['cidade'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($pedido['cep']); ?></td>
                        <td><?php echo htmlspecialchars(html_entity_decode($pedido['estado'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($pedido['data_venda'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <footer>
        <?php include "footer.php"; ?>
    </footer>
</body>

</html> 