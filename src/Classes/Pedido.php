<?php

namespace Renato\Comex\Classes;

// Desenvolvendo a Classe Pedido
class Pedido {
    private int $id;
    private Cliente $cliente;
    private array $produtos;

    public function __construct(int $id, Cliente $cliente, array $produtos) {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->produtos = $produtos;
    }

    // Implementando Getters e Setters
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getCliente(): Cliente {
        return $this->cliente;
    }

    public function setCliente(Cliente $cliente): void {
        $this->cliente = $cliente;
    }

    public function getProdutos(): array {
        return $this->produtos;
    }

    public function setProdutos(array $produtos): void {
        $this->produtos = $produtos;
    }

    public function adicionarProduto(Produto $produto, int $quantidade): void {
        // Verifica se o produto já existe no pedido
        foreach ($this->produtos as &$item) {
            if ($item['produto']->getCodigo() === $produto->getCodigo()) {
                $item['quantidade'] += $quantidade;
                return;
            }
        }
        // Se não existir, adiciona o produto ao pedido
        $this->produtos[] = ['produto' => $produto, 'quantidade' => $quantidade];
    }

    public function calcularValorTotal(): float {
        $total = 0.0;
        foreach ($this->produtos as $item) {
            $total += $item['produto']->getPreco() * $item['quantidade'];
        }
        return $total;
    }

    public function mostrarDetalhesPedido(): void {
        echo "Pedido ID: " . $this->id . PHP_EOL;
        echo "Cliente: " . $this->cliente->getNome() . PHP_EOL;
        echo "Produtos: " . PHP_EOL;
        foreach ($this->produtos as $item) {
            echo "- " . $item['produto']->getNome() . " (Quantidade: " . $item['quantidade'] . ")" . PHP_EOL;
        }
        echo "Valor Total: R$ " . number_format($this->calcularValorTotal(), 2, ',', '.') . PHP_EOL;
    }
}
