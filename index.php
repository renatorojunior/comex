<?php

require_once __DIR__ . '/vendor/autoload.php';

use Renato\Comex\Classes\Cliente;
use Renato\Comex\Classes\Produto;
use Renato\Comex\Classes\Pedido;
use Renato\Comex\Classes\CarrinhoDeCompras;

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

echo "----------------------------------------------------------------" . PHP_EOL;

$produto2 = new Produto("0502", "Amplificador Marshall", 6036.99, 3);

//Faz Pedido
$pedido = new Pedido(001, $cliente, []);
$pedido->adicionarProduto($produto, 1);
$pedido->adicionarProduto($produto2, 1);

//Mostra Detalhes do Pedido
$pedido->mostrarDetalhesPedido();

echo "----------------------------------------------------------------" . PHP_EOL;

$produto3 = new Produto("0378", "Pedaleira BOSS GX-100", 5354.15, 4);
$produto4 = new Produto("0984", "Transmissor Wirelles Line 6 - G30", 1081.62, 10);

$pedido2 = new Pedido(002, $cliente, []);
$pedido2->adicionarProduto($produto3, 1);
$pedido2->adicionarProduto($produto4, 1);

// Adicionando pedidos à lista de pedidos do cliente
$cliente->adicionarPedido($pedido);
$cliente->adicionarPedido($pedido2);

// Obtendo a lista de pedidos do cliente
$listaPedidos = $cliente->getPedidos();

// Iterando sobre a lista de pedidos e mostrando detalhes
foreach ($listaPedidos as $pedido) {
    $pedido->mostrarDetalhesPedido();

    echo PHP_EOL;
}

echo "----------------------------------------------------------------" . PHP_EOL;

$carrinho = new CarrinhoDeCompras();
$carrinho->adicionarProduto($produto, 1);
$carrinho->adicionarProduto($produto3, 1);
$carrinho->adicionarProduto($produto4, 1);

echo "Produtos no carrinho:" . PHP_EOL;
$carrinho->mostrarProdutos();

$percentualDesconto = 10; // 10% de desconto
$valorFrete = 25.0; // R$ 25,00 de frete

$totalCompra = $carrinho->calcularTotalCompra($percentualDesconto, $valorFrete);
echo "Total da compra com desconto e frete: R$ " .  number_format($totalCompra, 2, ',', '.') . PHP_EOL;

echo "----------------------------------------------------------------" . PHP_EOL;

$cliente->exibirDadosCliente();

echo PHP_EOL;

$cliente->setCelular("13981596915");
$cliente->exibirDadosCliente();
?>