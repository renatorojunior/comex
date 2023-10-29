<?php

namespace Renato\Comex\Modelo;

use InvalidArgumentException, LogicException;

// Classe Pedido
class Pedido {
    private int $id;
    private Cliente $cliente;
    private array $produtos;

    public function __construct(int $id, Cliente $cliente, array $produtos) {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->produtos = $produtos;
    }

    //Getters e Setters
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

    // Método para adicionar produto ao pedido com tratamento de exceções.
    public function adicionarProduto(Produto $produto, int $quantidade): void {
        try {
            // Verifica se o produto já existe no pedido
            foreach ($this->produtos as &$item) {
                if ($item['produto']->getCodigo() === $produto->getCodigo()) {
                    if ($quantidade <= 0) {
                        throw new InvalidArgumentException("A quantidade deve ser maior que zero.");
                    }
                    $item['quantidade'] += $quantidade;
                    return;
                }
            }
            // Se não existir, adiciona o produto ao pedido
            if ($quantidade <= 0) {
                throw new InvalidArgumentException("A quantidade deve ser maior que zero.");
            }
            $this->produtos[] = ['produto' => $produto, 'quantidade' => $quantidade];
        } catch (InvalidArgumentException $e) {
            echo "Erro ao adicionar produto ao pedido: " . $e->getMessage() . PHP_EOL;
        }
    }

    // Método calcular valor total do pedido com tratamento de Exceções.
    public function calcularValorTotal(): float {
        $total = 0.0;
        try {
            foreach ($this->produtos as $item) {
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

    public function mostrarDetalhesPedido(): void {
        echo "Pedido ID: " . $this->id . PHP_EOL;
        echo "Cliente: " . $this->cliente->getNome() . PHP_EOL;
        echo "Produtos: " . PHP_EOL;
        foreach ($this->produtos as $item) {
            echo "- " . $item['produto']->getNome() . " (Quantidade: " . $item['quantidade'] . ")" . PHP_EOL;
        }
        echo "Valor Total do pedido: R$ " . number_format($this->calcularValorTotal(), 2, ',', '.') . PHP_EOL;
    }
}

?>