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

// Função para Analisar os Produtos em Estoque
function analisarProdutosExtremos($produtos) {
    $produtoMaisCaro = null;
    $produtoMaisBarato = null;
    $precos = array_column($produtos, 'preco');
    $produtoMaisCaroPreco = max($precos);
    $produtoMaisBaratoPreco = min($precos);

    foreach ($produtos as $produto => $detalhes) {
        if ($detalhes['preco'] == $produtoMaisCaroPreco) {
            $produtoMaisCaro = $produto;
        }
        if ($detalhes['preco'] == $produtoMaisBaratoPreco) {
            $produtoMaisBarato = $produto;
        }
    }

    return array("mais_caro" => $produtoMaisCaro, "mais_barato" => $produtoMaisBarato);
}

$precos = array_column($produtos, 'preco');
$mediaPrecos = array_sum($precos) / count($precos);

$resultado = analisarProdutosExtremos($produtos);

echo "Produto mais caro: " . $resultado['mais_caro'] . " - R$" . number_format($produtos[$resultado['mais_caro']]['preco'], 2, ',', '.') . "" . PHP_EOL;
echo "Produto mais barato: " . $resultado['mais_barato'] . " - R$" . number_format($produtos[$resultado['mais_barato']]['preco'], 2, ',', '.') . "" . PHP_EOL;
echo "Média de preços: R$" . number_format($mediaPrecos, 2, ',', '.') . PHP_EOL;

?>
