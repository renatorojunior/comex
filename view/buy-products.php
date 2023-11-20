<?php

require_once('../config/connection.php');
require_once __DIR__ . '/../src/Infrastructure/Repository/PdoProductRepository.php';
require_once __DIR__ . '/../src/Domain/Model/Product.php'; 

use Renato\Comex\Infrastructure\Repository\PdoProductRepository;
use Renato\Comex\Domain\Model\Product;

$pdoProductRepository = new PdoProductRepository($pdo);
$products = $pdoProductRepository->allProducts();

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Validar a quantidade 
    if ($quantity > 0) {
        $pdoProductRepository = new PdoProductRepository($pdo);
        $product = $pdoProductRepository->findProductById($productId);

        // Verificar se há estoque suficiente
        if ($product->getStockQuantity() >= $quantity) {
            // Calcular o preço total da transação
            $totalPrice = $quantity * $product->getProductPrice();
        
            // Atualizar o banco de dados (subtrair a quantidade comprada do estoque)
            $newStockQuantity = $product->getStockQuantity() - $quantity;
            $pdoProductRepository->updateStockQuantity($productId, $newStockQuantity);
        
            // Registrar a transação na tabela de pedidos
            $stmt = $pdo->prepare("INSERT INTO orders (product_id, quantity, total_price) VALUES (?, ?, ?)");
            $stmt->execute([$productId, $quantity, $totalPrice]);
        
            // Redirecionar para a página de confirmação
            header('Location: confirmation.php');
            exit();
        } else {
            echo "Quantidade insuficiente em estoque.";
        }
    } else {
        echo "Quantidade inválida.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/buy-products.css">
    <title>Produtos Disponíveis</title>
</head>

<body>
    <section class="products-container">
        <div class="title">
            <h2>Produtos Disponíveis</h2>
        </div>
        <div class="table">
            <table border="1">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Código do Produto</th>
                        <th>Nome do Produto</th>
                        <th>Preço</th>
                        <th>Quantidade em Estoque</th>
                        <th>Comprar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?php echo $product->getProductId(); ?></td>
                            <td><?php echo $product->getProductCode(); ?></td>
                            <td><?php echo $product->getProductName(); ?></td>
                            <td><?php echo 'R$ ' . $product->getProductPrice(); ?></td>
                            <td><?php echo $product->getStockQuantity(); ?></td>
                            <td>
                                <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
                                    <input type='hidden' name='product_id' value='<?php echo $product->getProductId(); ?>'>
                                    <input type='hidden' name='csrf_token' value='<?php echo $_SESSION['csrf_token']; ?>'>
                                    <label for='quantity'>Quantidade:</label>
                                    <input type='number' name='quantity' id='quantity' value='0' min='0' max='<?php echo $product->getStockQuantity(); ?>'>
                                    <input type='submit' name='action' value='Comprar'>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>
