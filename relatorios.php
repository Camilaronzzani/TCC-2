<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id_cliente']) || $_SESSION['id_cliente'] != 1) {
    header('Location: login.php');
    exit();
}

$stmt_pedidos = $pdo->prepare("SELECT * FROM tb_vendas");
$stmt_pedidos->execute();
$pedidos = $stmt_pedidos->fetchAll(PDO::FETCH_ASSOC);

$stmt_brindes = $pdo->prepare("SELECT * FROM tb_brindes");
$stmt_brindes->execute();
$brindes = $stmt_brindes->fetchAll(PDO::FETCH_ASSOC);

$stmt_assinantes = $pdo->prepare("SELECT * FROM tb_clientes WHERE id_brinde IS NOT NULL");
$stmt_assinantes->execute();
$assinantes = $stmt_assinantes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Relatórios</title>
</head>

<body>

    <header>
        <!-- Navbar -->
        <?php include "nav.php"; ?>
    </header>

    <main class="p-6 bg-gray-100">
        <h1 class="text-3xl font-bold mb-6">Relatórios</h1>

        <h2 class="text-2xl font-semibold mb-4">Pedidos Realizados</h2>
        <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-md mb-6">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">ID do Pedido</th>
                    <th class="px-4 py-2 text-left">Nome</th>
                    <th class="px-4 py-2 text-left">Endereço</th>
                    <th class="px-4 py-2 text-left">Cidade</th>
                    <th class="px-4 py-2 text-left">CEP</th>
                    <th class="px-4 py-2 text-left">Estado</th>
                    <th class="px-4 py-2 text-left">Data do Pedido</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2"><?php echo $pedido['id_venda']; ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars(html_entity_decode($pedido['nome']), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars(html_entity_decode($pedido['endereco']), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars(html_entity_decode($pedido['cidade']), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($pedido['cep'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars(html_entity_decode($pedido['estado']), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-2"><?php echo date('d/m/Y H:i', strtotime($pedido['data_venda'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="text-2xl font-semibold mb-4">Brindes Disponíveis</h2>
        <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-md mb-6">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">ID do Brinde</th>
                    <th class="px-4 py-2 text-left">Nome</th>
                    <th class="px-4 py-2 text-left">Preço</th>
                    <th class="px-4 py-2 text-left">Data de Cadastro</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($brindes as $brinde): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2"><?php echo $brinde['id_brinde']; ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($brinde['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-2"><?php echo 'R$ ' . number_format($brinde['preco'], 2, ',', '.'); ?></td>
                        <td class="px-4 py-2"><?php echo date('d/m/Y', strtotime($brinde['data_cadastro'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="text-2xl font-semibold mb-4">Assinantes (Clientes com Brindes)</h2>
        <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-md mb-6">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">ID do Cliente</th>
                    <th class="px-4 py-2 text-left">Nome</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Telefone</th>
                    <th class="px-4 py-2 text-left">Endereço</th>
                    <th class="px-4 py-2 text-left">Data de Cadastro</th>
                    <th class="px-4 py-2 text-left">Brinde</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assinantes as $assinante): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2"><?php echo $assinante['id_cliente']; ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($assinante['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($assinante['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($assinante['telefone'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($assinante['endereco'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="px-4 py-2"><?php echo date('d/m/Y', strtotime($assinante['data_cadastro'])); ?></td>
                        <td class="px-4 py-2">
                            <?php
                            $stmt_brinde_cliente = $pdo->prepare("SELECT nome FROM tb_brindes WHERE id_brinde = :id_brinde");
                            $stmt_brinde_cliente->execute(['id_brinde' => $assinante['id_brinde']]);
                            $brinde_cliente = $stmt_brinde_cliente->fetch(PDO::FETCH_ASSOC);
                            echo $brinde_cliente ? htmlspecialchars($brinde_cliente['nome'], ENT_QUOTES, 'UTF-8') : 'Nenhum';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <?php include "footer.php"; ?>
    </footer>

</body>

</html>