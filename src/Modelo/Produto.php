<?php

namespace Renato\Comex\Modelo;

use InvalidArgumentException;
use Renato\Comex\Exception\NotFoundProductException;

//Classe Produto
class Produto {
    private string $codigo;
    private string $nome;
    private float $preco;
    private int $quantidadeEstoque;

    public function __construct(string $codigo, string $nome, float $preco, int $quantidadeEstoque) {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidadeEstoque = $quantidadeEstoque;
    }

    //Getters e Setters
    public function getCodigo(): string {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): void {
        $this->codigo = $codigo;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getPreco(): float {
        return $this->preco;
    }

    public function setPreco(float $preco): void {
        $this->preco = $preco;
    }

    public function getQuantidadeEstoque(): int {
        return $this->quantidadeEstoque;
    }

    public function setQuantidadeEstoque(int $quantidadeEstoque): void {
        $this->quantidadeEstoque = $quantidadeEstoque;
    }

    // Método para adicionar uma quantidade de produtos ao estoque com tratamento de exceçõeos
    public function adicionarProduto(string $codigo, int $quantidade): void {
        if ($this->codigo === $codigo) {
            if ($quantidade <= 0) {
                throw new InvalidArgumentException("A quantidade a ser adicionada deve ser maior que zero.");
            }
    
            $this->quantidadeEstoque += $quantidade;
        } else {
            throw new InvalidArgumentException("Produto com código '$codigo' não encontrado.");
        }
    }

    // Método para remover uma quantidade de produtos do estoque com tratamento de exceções
    public function removerProduto(string $codigo, int $quantidade): void {
        if ($this->codigo === $codigo) {
            if ($quantidade <= 0) {
                throw new InvalidArgumentException("A quantidade a ser removida deve ser maior que zero.");
            }
    
            if ($quantidade > $this->quantidadeEstoque) {
                throw new InvalidArgumentException("Quantidade insuficiente em estoque.");
            }
    
            $this->quantidadeEstoque -= $quantidade;
        } else {
            throw new InvalidArgumentException("Produto com código '$codigo' não encontrado.");
        }
    }
    
    public function calcularValorTotal(): float {
        return $this->preco * $this->quantidadeEstoque;
    }
    
    // Método para exibir o estoque do produto com validação do código do produto com tratamento de exceções
    public function exibirEstoque(string $codigoProduto): void {
        if ($this->codigo === $codigoProduto) {
            echo "Produto: " . $this->nome . ". Quantidade em Estoque: " . $this->quantidadeEstoque . PHP_EOL;
        } else {
            throw new NotFoundProductException("Produto com código '$codigoProduto' não encontrado.");
        }
    }
}

?>
