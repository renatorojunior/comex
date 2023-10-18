<?php

require ('produtos.php');

// Função para adicionar produtos ao estoque
function adicionarProduto($produto, $preco, $quantidade) {
    global $produtos;
    if (isset($produtos[$produto])) {
        $produtos[$produto]['estoque'] += $quantidade;
    } else {
        $produtos[$produto] = array("preco" => $preco, "estoque" => $quantidade);
    }
}

// Função para remover produtos do estoque
function removerProduto($produto, $quantidade) {
    global $produtos;
    if (isset($produtos[$produto])) {
        if ($produtos[$produto]['estoque'] >= $quantidade) {
            $produtos[$produto]['estoque'] -= $quantidade;
        } else {
            echo "Não há quantidade suficiente em estoque para o produto '$produto'.";
        }
    } else {
        echo "Produto '$produto' não encontrado no estoque.";
    }
}

// Função para verificar a disponibilidade de um produto no estoque
function verificarDisponibilidade($produto, $quantidadeDesejada, $produtos) {
    if (isset($produtos[$produto]) && $produtos[$produto]['estoque'] >= $quantidadeDesejada) {
        $quantidadeDisponivel = $produtos[$produto]['estoque'];
        return "Produto '$produto' está disponível no estoque em quantidade suficiente. Quantidade disponível: $quantidadeDisponivel unidades.";
    } else if (isset($produtos[$produto])) {
        $quantidadeDisponivel = $produtos[$produto]['estoque'];
        return "Desculpe, o produto '$produto' não está disponível em quantidade suficiente no estoque. Quantidade disponível: $quantidadeDisponivel unidades.";
    } else {
        return "O produto '$produto' não foi encontrado no estoque.";
    }
}

// Exemplos de uso das funções
adicionarProduto("Amplificador Marshall", 5000.00, 2);
removerProduto("Guitarra Strato Fender", 3);
echo verificarDisponibilidade("Guitarra Les Paul Gibson", 2, $produtos).PHP_EOL;
echo verificarDisponibilidade("Amplificador Marshall", 3, $produtos).PHP_EOL;
echo verificarDisponibilidade("Amplificador Meteoro", 1, $produtos).PHP_EOL;

// Função para exibir a lista de produtos com quantidades em estoque
function listarProdutosComEstoque($produtos) {
    foreach ($produtos as $produto => $detalhes) {
        echo "$produto - Preço: R$ " . number_format($detalhes['preco'], 2, ',', '.') . " - Estoque: " . $detalhes['estoque'] . " unidades".PHP_EOL;
    }    
}

// Exibindo a lista de produtos com quantidades em estoque
listarProdutosComEstoque($produtos);

?>
