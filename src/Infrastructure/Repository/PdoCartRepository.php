<?php

namespace Renato\Comex\Infrastructure\Repository;

use PDO;
use Renato\Comex\Domain\Model\{Cart, Product};
use Renato\Comex\Domain\Repository\CartRepository;
use InvalidArgumentException;

class PdoCartRepository implements CartRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function addToCart(string $productId, int $quantity): void
    {
        // Verificar se o produto já existe no carrinho
        $existingProduct = $this->getProductInCart($productId);

        if ($existingProduct) {
            // Atualizar a quantidade do produto no carrinho
            $this->updateProductQuantityInCart($productId, $existingProduct['quantity'] + $quantity);
        } else {
            // Adicionar um novo produto ao carrinho
            $this->addNewProductToCart($productId, $quantity);
        }
    }

    public function removeFromCart(string $productId): void
    {
        $stmt = $this->connection->prepare('DELETE FROM cart WHERE product_id = :product_id');
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function viewCart(): Cart
    {
        $stmt = $this->connection->query('SELECT * FROM cart');
        $cartData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cart = new Cart();
        foreach ($cartData as $item) {
            $product = $this->getProductById($item['product_id']);
            $cart->addProduct($product, (int)$item['quantity']);
        }

        return $cart;
    }

    public function clearCart(): void
    {
        $this->connection->exec('TRUNCATE TABLE cart');
    }

    // Métodos complementares
    private function getProductInCart(string $productId): ?array
    {
        $stmt = $this->connection->prepare('SELECT * FROM cart WHERE product_id = :product_id');
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function updateProductQuantityInCart(string $productId, int $quantity): void
    {
        $stmt = $this->connection->prepare('UPDATE cart SET quantity = :quantity WHERE product_id = :product_id');
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_STR);
        $stmt->execute();
    }

    private function addNewProductToCart(string $productId, int $quantity): void
    {
        $stmt = $this->connection->prepare('INSERT INTO cart (product_id, quantity) VALUES (:product_id, :quantity)');
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function getProductById(string $productId): Product
    {
        $stmt = $this->connection->prepare('SELECT * FROM products WHERE id = :product_id');
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_STR);
        $stmt->execute();

        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$productData) {
            throw new InvalidArgumentException("Produto com ID '$productId' não encontrado.");
        }

        return new Product(
            $productData['code'],
            $productData['name'],
            (float)$productData['price'],
            (int)$productData['stock_quantity']
        );
    }
}

?>