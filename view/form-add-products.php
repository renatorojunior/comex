<?php
require_once('../config/connection.php');
require_once __DIR__ . '/../src/Infrastructure/Repository/PdoProductRepository.php';
require_once __DIR__ . '/../src/Domain/Model/Product.php';

use Renato\Comex\Infrastructure\Repository\PdoProductRepository;
use Renato\Comex\Domain\Model\Product;

$pdoProductRepository = new PdoProductRepository($pdo);

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stock_quantity'];

    // Cria uma instância do objeto Product
    $product = new Product($code, $name, (float)$price, (int)$stockQuantity);

    // Salva o novo produto no banco de dados
    $addProduct = $pdoProductRepository->save($product);

    if ($addProduct === true) {        
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo 'Erro ao inserir produto.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Cadastro de Produtos</title>
</head>
<body>
    <div class="container">
        <div class="form-image">
            <img src="./assets/img/data_processing.svg" alt="Imagem ilustrativa de processamento de dados.">
        </div>
        <div class="form-register">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-title">
                    <h2>Cadastro de Produtos</h2>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="code">Código do Produto:</label>
                        <input type="text" id="code" name="code" placeholder="Digite o código" required><br>
                    </div>

                    <div class="input-box">
                        <label for="name">Nome do Produto:</label>
                        <input type="text" id="name" name="name" placeholder="Digite o nome do produto" required><br>
                    </div>

                    <div class="input-box">
                        <label for="price">Preço do Produto:</label>
                        <input type="number" id="price" name="price" step="0.01" placeholder="Digite o valor do produto"  required><br>
                    </div>

                    <div class="input-box">
                        <label for="stock_quantity">Quantidade em Estoque:</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" placeholder="Digite a quantidade"  required><br>
                    </div>
                </div>
                <div class="submit-button">
                    <input type="submit" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
</body>
</html>



