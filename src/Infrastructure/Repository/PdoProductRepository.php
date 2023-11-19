<?php

namespace Renato\Comex\Infrastructure\Repository;

require_once __DIR__ . '/../../Domain/Repository/ProductRepository.php';

use PDO;
use Renato\Comex\Domain\Model\Product;
use Renato\Comex\Domain\Repository\ProductRepository;

class PdoProductRepository implements ProductRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allProducts(): array
    {
        $stmt = $this->connection->query('SELECT * FROM products');
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($productsData as $data) {
            $products[] = $this->createProductFromData($data);
        }

        return $products;
    }

    public function findProductById(string $productId): ?Product
    {
        $stmt = $this->connection->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->createProductFromData($data) : null;
    }

    public function findProductByCode(string $code): ?Product
    {
        $stmt = $this->connection->prepare('SELECT * FROM products WHERE code = :product_code');
        $stmt->bindParam(':product_code', $code, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->createProductFromData($data) : null;
    }

    public function save(Product $product): bool
{
    $code = $product->getProductCode();
    $name = $product->getProductName();
    $price = $product->getProductPrice();
    $stockQuantity = $product->getStockQuantity();

    $stmt = $this->connection->prepare('INSERT INTO products (product_code, product_name, price, stock_quantity) VALUES (:code, :name, :price, :stock_quantity)');
    $stmt->bindParam(':code', $code, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    $stmt->bindParam(':stock_quantity', $stockQuantity, PDO::PARAM_INT);

    return $stmt->execute();
}

    public function remove(Product $product): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM products WHERE id = :id');
        $stmt->bindParam(':id', $product->getProductId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function update(Product $product): bool
    {
        $stmt = $this->connection->prepare('UPDATE products SET code = :product_code, product_name = :product_name, price = :price, stock_quantity = :stock_quantity WHERE id = :id');
        $stmt->bindParam(':id', $product->getProductId(), PDO::PARAM_INT);
        $stmt->bindParam(':product_code', $product->getProductCode(), PDO::PARAM_STR);
        $stmt->bindParam(':product_name', $product->getProductName(), PDO::PARAM_STR);
        $stmt->bindParam(':price', $product->getProductPrice(), PDO::PARAM_INT);
        $stmt->bindParam(':stock_quantity', $product->getStockQuantity(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Método auxiliar para instânciar um Produto a partir dos dados do banco
    private function createProductFromData(array $data): Product
    {
        $product = new Product($data['product_code'], $data['product_name'], (float)$data['price'], (int)$data['stock_quantity']);
        
        return $product;
    }
}

?>