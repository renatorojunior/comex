<?php

require_once __DIR__ . '/vendor/autoload.php';

use Renato\Comex\Classes\{Cliente, Produto, Pedido, CarrinhoDeCompras};

// Lista de Clientes
$cliente = new Cliente("438.606.060-00", "Guilherme Augusto Bartolomeu", "guilherme.abartolomeu@email.com", "(13) 98765-4321", "Rua General Oliveira, 523");

// Lista de Produtos
$produto1 = new Produto("0142", "Guitarra Les Paul Gibson",38560.05, 2);
$produto2 = new Produto("0502", "Amplificador Marshall", 6036.99, 3);
$produto3 = new Produto("0378", "Pedaleira BOSS GX-100", 5354.15, 4);
$produto4 = new Produto("0984", "Transmissor Wirelles Line 6 - G30", 1081.62, 10);

// Exemplo de uso das funções adicionarProduto() e removerProduto()
$produto1->adicionarProduto("0142", -5); // Tentando adicionar produto com quantidade negativa.
$produto3->adicionarProduto("0284", 10); // Tentando adicionar produto com código de produto errado.
$produto2->removerProduto("0502", 10); // Tentando remover quantidade maior que quantidade em estoque.
$produto4->removerProduto("0258", 10); // Tentando remover produto com código de produto errado.
$produto1->removerProduto("0142", -3); // Tentando remover produto com quantidade negativa.

?>