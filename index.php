<?php

require_once __DIR__ . '/vendor/autoload.php';

use Renato\Comex\Cliente;

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

?>