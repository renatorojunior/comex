<?php

namespace Renato\Comex\Classes;

use InvalidArgumentException;

// Desenvolvendo a Classe Produto
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

    //Implementando Getters e Setters
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

    public function adicionarProduto(string $codigo, int $quantidade): void {
        try {
            if ($this->codigo === $codigo) {
                if ($quantidade <= 0) {
                    throw new InvalidArgumentException("A quantidade a ser adicionada deve ser maior que zero.");
                }

                $this->quantidadeEstoque += $quantidade;
                echo "Produto adicionado com sucesso. Nova quantidade em estoque: " . $this->quantidadeEstoque . PHP_EOL;
            } else {
                throw new InvalidArgumentException("Produto com código '$codigo' não encontrado.");
            }
        } catch (InvalidArgumentException $e) {
            echo "Erro ao adicionar produto: " . $e->getMessage() . PHP_EOL;
        }
    }

    public function removerProduto(string $codigo, int $quantidade): void {
        try {
            if ($this->codigo === $codigo) {
                if ($quantidade <= 0) {
                    throw new InvalidArgumentException("A quantidade a ser removida deve ser maior que zero.");
                }

                if ($quantidade > $this->quantidadeEstoque) {
                    throw new InvalidArgumentException("Quantidade insuficiente em estoque.");
                }

                $this->quantidadeEstoque -= $quantidade;
                echo "Produto removido com sucesso. Nova quantidade em estoque: " . $this->quantidadeEstoque . PHP_EOL;
            } else {
                throw new InvalidArgumentException("Produto com código '$codigo' não encontrado.");
            }
        } catch (InvalidArgumentException $e) {
            echo "Erro ao remover produto: " . $e->getMessage() . PHP_EOL;
        }
    }
    
    public function calcularValorTotal(): float {
        return $this->preco * $this->quantidadeEstoque;
    }
    
    public function exibirEstoque(): void {
        echo "Produto: " . $this->nome . PHP_EOL;
        echo "Quantidade em Estoque: " . $this->quantidadeEstoque . PHP_EOL;
    }
}

?>
