<?php

namespace Renato\Comex\Classes;

class CarrinhoDeCompras {
    private array $produtos = [];

    // Método para adicionar um produto ao carrinho
    public function adicionarProduto(Produto $produto, int $quantidade): void {
        $this->produtos[] = ['produto' => $produto, 'quantidade' => $quantidade];
    }

    // Método para remover um produto do carrinho
    public function removerProduto(Produto $produto): void {
        foreach ($this->produtos as $key => $item) {
            if ($item['produto'] === $produto) {
                unset($this->produtos[$key]);
                break;
            }
        }
        // Reindexa o array após a remoção
        $this->produtos = array_values($this->produtos);
    }

    // Método para calcular o valor total dos produtos no carrinho
    public function calcularTotal(): float {
        $total = 0.0;
        foreach ($this->produtos as $item) {
            $total += $item['produto']->getPreco() * $item['quantidade'];
        }
        return $total;
    }

    // Método para calcular o desconto na compra
    public function calcularDesconto(float $percentualDesconto): float {
        $total = $this->calcularTotal();
        $desconto = $total * ($percentualDesconto / 100);
        return $desconto;
    }

    // Método para calcular o valor do frete
    public function calcularFrete(float $valorFrete): float {
        return $valorFrete;
    }

    // Método para calcular o total da compra após desconto e frete
    public function calcularTotalCompra(float $percentualDesconto, float $valorFrete): float {
        $total = $this->calcularTotal();
        $desconto = $this->calcularDesconto($percentualDesconto);
        $total -= $desconto;
        $total += $this->calcularFrete($valorFrete);
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