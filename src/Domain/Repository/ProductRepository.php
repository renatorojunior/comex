<?php

namespace Renato\Comex\Domain\Repository;

use Renato\Comex\Domain\Model\Product;

interface ProductRepository
{
    public function allProducts(): array;
    public function findProductById(string $productId): ?Product;
    public function findProductByCode(string $code): ?product;    
    public function save(Product $product): bool;
    public function remove(Product $product): bool;
    public function update(Product $product): bool;
}

?>