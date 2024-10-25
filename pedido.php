<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit;
}

$id_pedido = $_GET['id_pedido'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Pedido Finalizado - RM Sports</title>
</head>

<body>
    <header>
        <?php include "nav.php"; ?>
    </header>

    <main>
        <div class="login-container">
            <div class="container">
                <h2>Pedido Finalizado com Sucesso!</h2>
                <p>Obrigado pela sua compra, <?php echo htmlspecialchars($_SESSION['nome_cliente']); ?>!</p>
                <p>Seu pedido de número <strong><?php echo htmlspecialchars($id_pedido); ?></strong> foi finalizado com sucesso.</p>
                <p>Em breve, você receberá um e-mail com a confirmação e os detalhes da entrega.</p>
                <a href="index.php" class="btn">Voltar à Loja</a>
                <a href="meus_pedidos.php" class="btn">Ver Meus Pedidos</a>
            </div>
        </div>
    </main>

    <footer>
        <?php include "footer.php"; ?>
    </footer>
</body>

</html>