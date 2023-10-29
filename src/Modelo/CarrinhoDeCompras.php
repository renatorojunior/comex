<?php

namespace Renato\Comex\Modelo;

use InvalidArgumentException, LogicException;

// Classe Carrinho de Compras
class CarrinhoDeCompras {
    private array $produtos = [];

    // Método para adicionar um produto ao carrinho com tratamento de Exceções
    public function adicionarProduto(Produto $produto, int $quantidade): void {
        try {
            if ($quantidade <= 0) {
                throw new InvalidArgumentException("Quantidade inválida. A quantidade deve ser maior que zero.");
            }
            $this->produtos[] = ['produto' => $produto, 'quantidade' => $quantidade];
        } catch (InvalidArgumentException $e) {
            echo "Erro ao adicionar produto ao carrinho: " . $e->getMessage() . PHP_EOL;
        }
    }

    // Método para remover um produto do carrinho com tratamento de Exceções
    public function removerProduto(Produto $produto): void {
        try {
            $produtoEncontrado = false;
            foreach ($this->produtos as $key => $item) {
                if ($item['produto'] === $produto) {
                    unset($this->produtos[$key]);
                    $produtoEncontrado = true;
                    break;
                }
            }
            if (!$produtoEncontrado) {
                throw new LogicException("Produto não encontrado no carrinho.");
            }
            // Reindexa o array após a remoção
            $this->produtos = array_values($this->produtos);
        } catch (LogicException $e) {
            echo "Erro ao remover produto do carrinho: " . $e->getMessage() . PHP_EOL;
        }
    }

    // Método para calcular o valor total dos produtos no carrinho
    public function calcularTotal(): float {
        $total = 0.0;
        foreach ($this->produtos as $item) {
            $total += $item['produto']->getPreco() * $item['quantidade'];
        }
        return $total;
    }

    // Método para mostrar os produtos no carrinho
    public function mostrarProdutos(): void {
        foreach ($this->produtos as $item) {
            echo $item['produto']->getNome() . " - Quantidade: " . $item['quantidade'] . PHP_EOL;
        }
    }
}

?>