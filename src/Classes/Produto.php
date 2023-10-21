<?php

namespace Renato\Comex\Classes;

// Desenvolvendo a Classe Produto
class Produto {
    private string $codigo;
    private string $nome;
    private  $preco;
    private int $quantidadeEstoque;

    public function __construct(string $codigo, string $nome,  $preco, int $quantidadeEstoque) {
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
        if ($this->codigo === $codigo) {
            $this->quantidadeEstoque += $quantidade;
            echo "Produto adicionado com sucesso. Nova quantidade em estoque: " . $this->quantidadeEstoque . PHP_EOL;
        } else {
            echo "Erro: Produto com código '$codigo' não encontrado." . PHP_EOL;
        }
    }

    public function removerProduto(string $codigo, int $quantidade): void {
        if ($this->codigo === $codigo) {
            if ($quantidade <= $this->quantidadeEstoque) {
                $this->quantidadeEstoque -= $quantidade;
                echo "Produto removido com sucesso. Nova quantidade em estoque: " . $this->quantidadeEstoque . PHP_EOL;
            } else {
                echo "Erro: Quantidade insuficiente em estoque." . PHP_EOL;
            }
        } else {
            echo "Erro: Produto com código '$codigo' não encontrado." . PHP_EOL; 
        }
    }

    public function calcularValorTotal(): float {
        return $this->preco * $this->quantidadeEstoque;
    }    
}

?>
