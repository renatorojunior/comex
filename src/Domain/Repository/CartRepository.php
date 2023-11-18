<?php

namespace Renato\Comex\Domain\Repository;

use Renato\Comex\Domain\Model\Cart;

interface CartRepository
{
    public function addToCart(string $productId, int $quantity): void;
    public function removeFromCart(string $productId): void;
    public function viewCart(): Cart;
    public function clearCart(): void;
}


?>