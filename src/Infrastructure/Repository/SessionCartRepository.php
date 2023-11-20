<?php

namespace Renato\Comex\Infrastructure\Repository;

require_once __DIR__ . '/../../Domain/Model/Cart.php';
require_once __DIR__ . '/../../Domain/Repository/CartRepository.php';

use PDO;
use Renato\Comex\Domain\Model\{Cart, Product};
use Renato\Comex\Domain\Repository\CartRepository;
use InvalidArgumentException;

class SessionCartRepository implements CartRepository
{
    private PdoProductRepository $productRepository;

    public function __construct(PdoProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function addToCart(string $productId, int $quantity): void
    {
        $cart = $this->getCartFromSession();
        $product = $this->getProductById($productId);

        if ($product instanceof Product) {
            $cart->addProduct($product, $quantity);
            $this->saveCartToSession($cart);
        } else {
            throw new InvalidArgumentException("Produto com ID '$productId' não encontrado.");
        }
    }

    public function removeFromCart(string $productId): void
    {
        $cart = $this->getCartFromSession();
        $cart->removeProduct($productId);
        $this->saveCartToSession($cart);
    }

    public function viewCart(): Cart
    {
        return $this->getCartFromSession();
    }

    public function clearCart(): void
    {
        $this->saveCartToSession(new Cart());
    }

    // Métodos complementares
    private function getCartFromSession(): Cart
    {
        return $_SESSION['cart'] ?? new Cart();
    }

    private function saveCartToSession(Cart $cart): void
    {
        $_SESSION['cart'] = $cart;
    }

    private function getProductById(string $productId): ?Product    {
        
        $product = $this->productRepository->findProductById($productId);
        
        return $product;
    }

    public function getTotalAmount(): float
    {
        $total = 0.0;

        foreach ($this->getCartFromSession()->getProducts() as $item) {
            $product = $item['produto'];
            $quantity = $item['quantidade'];
            $total += $product->getProductPrice() * $quantity;
        }

        return $total;
    }
}

?>