<?php

require_once __DIR__ . '/vendor/autoload.php';

use Renato\Comex\Classes\Cliente;
use Renato\Comex\Classes\Produto;

// Exemplo de uso da classe Cliente
$cliente = new Cliente("438.606.060-00", "Guilherme Augusto Bartolomeu", "guilherme.abartolomeu@email.com", "(13) 98765-4321", "Rua General Oliveira, 523");
$cliente->setTotalCompras(500.75);

// Exibindo os valores atribuídos à classe
echo "CPF: " . $cliente->getCpf() . PHP_EOL;
echo "Nome: " . $cliente->getNome() . PHP_EOL;
echo "E-mail: " . $cliente->getEmail() . PHP_EOL;
echo "Celular: " . $cliente->getCelular() . PHP_EOL;
echo "Endereço: " . $cliente->getEndereco() . PHP_EOL;
echo "Total de Compras: R$ " . number_format($cliente->getTotalCompras(), 2, ',', '.') . PHP_EOL;

echo "----------------------------------------------------------------" . PHP_EOL;

// Exemplo de uso da classe Produto
$produto = new Produto("0142", "Guitarra Les Paul Gibson",38560.05, 2);

// Adicionando 3 unidades do produto
$produto->adicionarProduto("0142", 3);

// Removendo 1 unidades do produto
$produto->removerProduto("0142", 2);

// Exibindo o valor total em produtos no estoque
echo "Código do Produto: " . $produto->getCodigo() . PHP_EOL;
echo "Nome do Produto: " . $produto->getNome() . PHP_EOL;
echo "Preço do Produto: R$ " . number_format($produto->getPreco(), 2, ',', '.') . PHP_EOL;
echo "Quantidade em Estoque: " . $produto->getQuantidadeEstoque() . PHP_EOL;
echo "Valor Total em Estoque: R$ " . number_format($produto->calcularValorTotal(), 2, ',', '.') . PHP_EOL;

?>