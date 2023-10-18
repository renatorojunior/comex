<?php
// Lista de produtos 
$produtos = array(
    "Guitarra Strato Fender" => 18099.00,
    "Guitarra Telecaster Fender" => 8788.00,
    "Guitarra Les Paul Standard Gibson" => 37336.89,
    "Guitarra Super Strato Ibanez" => 14679.00,
    "Guitar Flying V Jackson" => 6299.00
);

// Exibindo cada produto
foreach ($produtos as $produto => $preco) {
    echo "$produto - R$ " . number_format($preco, 2, ',', '.')." ".PHP_EOL;
}
