<?php

namespace Renato\Comex\Domain\Model;

use InvalidArgumentException, LogicException;

// Classe Carrinho de Compras
class Cart {
    private array $products = [];

    // Método para obter a lista de produtos no carrinho
    public function getProducts(): array {
        return $this->products;
    }

    // Método para adicionar um produto ao carrinho com tratamento de Exceções
    public function addProduct(Product $product, int $quantity): void {
        try {
            if ($quantity <= 0) {
                throw new InvalidArgumentException("Quantidade inválida. A quantidade deve ser maior que zero.");
            }
            $this->products[] = ['produto' => $product, 'quantidade' => $quantity];
        } catch (InvalidArgumentException $e) {
            echo "Erro ao adicionar produto ao carrinho: " . $e->getMessage() . PHP_EOL;
        }
    }

    // Método para remover um produto do carrinho com tratamento de Exceções
    public function removeProduct(Product $product): void {
        try {
            $produtoEncontrado = false;
            foreach ($this->products as $key => $item) {
                if ($item['produto'] === $product) {
                    unset($this->products[$key]);
                    $produtoEncontrado = true;
                }
            }
            if (!$produtoEncontrado) {
                throw new LogicException("Produto não encontrado no carrinho.");
            }
            // Reindexa o array após a remoção
            $this->products = array_values($this->products);
        } catch (LogicException $e) {
            echo "Erro ao remover produto do carrinho: " . $e->getMessage() . PHP_EOL;
        }
    }

    // Método para calcular o valor total dos produtos no carrinho
    public function calculateTotal(): float {
        $total = 0.0;
        foreach ($this->products as $item) {
            $total += $item['produto']->getProductPrice() * $item['quantidade'];
        }
        return $total;
    }

    // Método para mostrar os produtos no carrinho
    public function showProducts(): void {
        foreach ($this->products as $item) {
            echo $item['produto']->getProductName() . " - Quantidade: " . $item['quantidade'] . PHP_EOL;
        }
    }
}

?>