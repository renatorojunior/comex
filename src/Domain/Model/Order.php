<?php

namespace Renato\Comex\Domain\Model;

use InvalidArgumentException, LogicException;

// Classe Pedido
class Order {
    private string $id;
    private string $number;
    private string $clientId;
    private array $products;
    private float $totalAmount;

    public function __construct(string $number, string $clientId, array $products, float $totalAmount) {       
        $this->number = $number;
        $this->clientId = $clientId;
        $this->products = $products;
        $this->totalAmount = $totalAmount;
    }

    //Getters e Setters
    public function getOrderId(): int {
        return $this->id;
    }

    public function getOrderNumber(): int {
        return $this->number;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getClient(): string {
        return $this->clientId;
    }

    public function setClient(string $clientId): void {
        $this->clientId = $clientId;
    }

    public function getProducts(): array {
        return $this->products;
    }

    public function setProducts(array $products): void {
        $this->products = $products;
    }

    // Método para adicionar produto ao pedido com tratamento de exceções.
    public function addProduct(Product $product, int $quantity): void {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("A quantidade deve ser maior que zero.");
        }
    
        // Itera sobre os produtos existentes no pedido
        foreach ($this->products as &$item) {
            if ($item['produto']->getCode() === $product->getProductCode()) {
                // Se o produto já existe, atualiza a quantidade
                $item['quantidade'] += $quantity;
                return;
            }
        }
    
        // Se o produto não existe, adiciona ao pedido
        $this->products[] = ['produto' => $product, 'quantidade' => $quantity];
    }
    

    // Método calcular valor total do pedido com tratamento de Exceções.
    public function getTotalAmount(): float {
        $total = 0.0;
        try {
            foreach ($this->products as $item) {
                if ($item['quantidade'] <= 0) {
                    throw new LogicException("Quantidade de produto inválida.");
                }
                $total += $item['produto']->getPreco() * $item['quantidade'];
            }
        } catch (LogicException $e) {
            echo "Erro ao calcular valor total do pedido: " . $e->getMessage() . PHP_EOL;
        }
        return $total;
    }

    public function showOrderDetail(): void {
        echo "Pedido ID: " . $this->id . PHP_EOL;
        echo "ID do Cliente: " . $this->clientId . PHP_EOL;
        echo "Produtos: " . PHP_EOL;
        foreach ($this->products as $item) {
            echo "- " . $item['product']->getProductName() . " (Quantidade: " . $item['quantity'] . ")" . PHP_EOL;
        }
        echo "Valor Total do pedido: R$ " . number_format($this->getTotalAmount(), 2, ',', '.') . PHP_EOL;
    }
        
}

?>