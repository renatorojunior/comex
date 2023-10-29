<?php

require_once __DIR__ . '/vendor/autoload.php';

use Renato\Comex\Modelo\{Cliente, Produto, Pedido, CarrinhoDeCompras};
use Renato\Comex\MeioDePagamento\{Boleto, CartaoDeCredito, Pix};

// Lista de Clientes
$cliente1 = new Cliente("438.606.060-00", "Guilherme Augusto Bartolomeu", "guilherme.abartolomeu@email.com", "(13) 98765-4321", "Rua General Oliveira, 523");

// Lista de Produtos
$produto1 = new Produto("0142", "Guitarra Les Paul Gibson",38560.05, 2);
$produto2 = new Produto("0502", "Amplificador Marshall", 6036.99, 3);
$produto3 = new Produto("0378", "Pedaleira BOSS GX-100", 5354.15, 4);
$produto4 = new Produto("0984", "Transmissor Wirelles Line 6 - G30", 1081.62, 10);

// Exemplo de uso das funções adicionarProduto() e removerProduto() com tratamento de exceções.
echo "Exemplos de uso das Regras de Estoque para as funções 'adicionarProduto()' e 'removerProduto()':" . PHP_EOL;
$produto1->adicionarProduto("0142", -5); // Tentando adicionar produto com quantidade negativa.
$produto3->adicionarProduto("0284", 10); // Tentando adicionar produto com código de produto errado.
$produto2->removerProduto("0502", 10); // Tentando remover quantidade maior que quantidade em estoque.
$produto4->removerProduto("0258", 10); // Tentando remover produto com código de produto errado.
$produto1->removerProduto("0142", -3); // Tentando remover produto com quantidade negativa.

echo "----------------------------------------------------------------" . PHP_EOL;

//Lista de Pedidos
$pedido1 = new Pedido(001, $cliente1, []);
$pedido1->adicionarProduto($produto1, 1);
$pedido1->adicionarProduto($produto2, 1);

$pedido2 = new Pedido(002, $cliente1, []);
$pedido2->adicionarProduto($produto3, 1);
$pedido2->adicionarProduto($produto4, 1);

// Adicionando pedidos à lista de pedidos do cliente
$cliente1->adicionarPedido($pedido1);
$cliente1->adicionarPedido($pedido2);

// Adicionando procutos ao carrinho de compras
$carrinho = new CarrinhoDeCompras();
$carrinho->adicionarProduto($produto1, 1);
$carrinho->adicionarProduto($produto3, 1);
$carrinho->adicionarProduto($produto4, 1);

// Exemplo de uso das demais funções do modelo com tratamento de exceções.
echo "Exemplos de uso das demais funções com tratamento de Exceções:" . PHP_EOL;
$carrinho->adicionarProduto($produto2, -2); //Tentanto adicionar produto ao carrinho com quantidade negativa.
$carrinho->removerProduto($produto2, 1); //Tentando remover produto que não existe no carrinho.
$cliente1->adicionarPedido($pedido1); //Tentando adicionar pedido na incluido na lista de pedidos.
$cliente1->setCelular('129515d111595'); //Tentando setar celular com formato invalido. 
$produto1->exibirEstoque("0452"); //Tentando exibir a quantidade de um produto em estoque com código errado.
$pedido2->adicionarProduto($produto2, -2); //Tentando adicionar produto ao carrinho com quantidade negativa.

echo "----------------------------------------------------------------" . PHP_EOL;

// Exemplo de uso de pagamento com a classe Pix.
echo "- Pagamento via Boleto:" . PHP_EOL . PHP_EOL;
$pagamentoPix = new Pix($cliente1);
$valorCompra = 100.25;

$pagamentoPix->processarPagamento($valorCompra);
echo PHP_EOL;

// Exemplo de uso de pagamento com a classe CartaoDeCredito.
echo "- Pagamento via Cartão de Crédito:" . PHP_EOL . PHP_EOL;
$pagamentoCartaoDeCredito = new CartaoDeCredito("1234 5678 8765 4321", $cliente1, "123");
$valorCompra = 200.75;

$pagamentoCartaoDeCredito->processarPagamento($valorCompra);
echo PHP_EOL;

// Exemplo de uso de pagamento com a classe Pix.
echo "- Pagamento via Pix:" . PHP_EOL . PHP_EOL;
$pagamentoPix = new Pix($cliente1);
$valorCompra = 350.99;

$pagamentoPix->processarPagamento($valorCompra);

?>