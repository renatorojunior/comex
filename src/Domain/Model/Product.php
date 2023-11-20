<?php

namespace Renato\Comex\Domain\Model;

use InvalidArgumentException;
use Renato\Comex\Exception\NotFoundProductException;

//Classe Produto
class Product
{
    private ?string $id;
    private string $code;
    private string $name;
    private float $price;
    private int $stockQuantity;

    public function __construct(string $id = null, string $code, string $name, float $price, int $stockQuantity)
    {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
    }

    //Getters e Setters
    public function getProductId(): ?string
    {
        return $this->id;
    }

    public function getProductCode(): string
    {
        return $this->code;
    }

    public function setProductCode(string $code): void
    {
        $this->code = $code;
    }

    public function getProductName(): string
    {
        return $this->name;
    }

    public function setProductName(string $name): void
    {
        $this->name = $name;
    }

    public function getProductPrice(): float
    {
        return $this->price;
    }

    public function setProductPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getStockQuantity(): int
    {
        return $this->stockQuantity;
    }

    public function setStockQuantity(int $stockQuantity): void
    {
        $this->stockQuantity = $stockQuantity;
    }

    // Método para adicionar uma quantidade de produtos ao estoque com tratamento de exceçõeos
    public function addProduct(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("A quantidade a ser adicionada deve ser maior que zero.");
        }

        $this->stockQuantity += $quantity;
    }



    // Método para remover uma quantidade de produtos do estoque com tratamento de exceções
    public function removeProduct(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("A quantidade a ser removida deve ser maior que zero.");
        }

        if ($quantity > $this->stockQuantity) {
            throw new InvalidArgumentException("Quantidade insuficiente em estoque.");
        }

        $this->stockQuantity -= $quantity;
    }

    public function calculateTotalValue(): float
    {
        return $this->price * $this->stockQuantity;
    }

    // Método para exibir o estoque do produto com validação do código do produto com tratamento de exceções
    public function getStockInfo(string $productCode): ?string
    {
        if ($this->code === $productCode) {
            return "Produto: " . $this->name . ". Quantidade em Estoque: " . $this->stockQuantity;
        }

        return null;
    }
}
