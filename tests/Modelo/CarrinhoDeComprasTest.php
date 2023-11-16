<?php

namespace Renato\Comex\Tests\Modelo;

use Renato\Comex\Modelo\{Cliente, Produto, Pedido, CarrinhoDeCompras};
use PHPUnit\Framework\TestCase;

class CarrinhoDeComprasTest extends TestCase {
    private CarrinhoDeCompras $carrinho;
    private Produto $produto1;
    private Produto $produto2;
    private Produto $produto3;    

    protected function setUp(): void {
        $this->carrinho = new CarrinhoDeCompras();
        $this->produto1 = new Produto("001", "Produto 1", 10.00, 5);
        $this->produto2 = new Produto("002", "Produto 2", 15.00, 10);
        $this->produto3 = new Produto("003", "Produto 3", 20.00, 8);               
    }

    // Testando a função getProdutos: 
    public function testGetProdutos(): void {
        $this->carrinho->adicionarProduto($this->produto1, 3);
        $this->carrinho->adicionarProduto($this->produto2, 2);
        
        $produtos = $this->carrinho->getProdutos();

        $this->assertCount(2, $produtos);
        $this->assertEquals("Produto 1", $produtos[0]['produto']->getNome());
        $this->assertEquals(10.0, $produtos[0]['produto']->getPreco());
        $this->assertEquals(3, $produtos[0]['quantidade']);

        $this->assertEquals("Produto 2", $produtos[1]['produto']->getNome());
        $this->assertEquals(15.0, $produtos[1]['produto']->getPreco());
        $this->assertEquals(2, $produtos[1]['quantidade']);
    }

    // Tentando adição de produto com quantidade válida e inválida no Carrinho:
    public function testAdicionarProdutoComQuantidadeValida(): void {        
        $this->carrinho->adicionarProduto($this->produto1, 3);
        $this->carrinho->adicionarProduto($this->produto2, 2);
        $this->carrinho->adicionarProduto($this->produto3, 5);
        $this->assertCount(3, $this->carrinho->getProdutos());
    }
    
    public function testAdicionarProdutoComQuantidadeInvalida(): void {        
        $this->carrinho->adicionarProduto($this->produto1, 0);
        $this->expectOutputString("Erro ao adicionar produto ao carrinho: Quantidade inválida. A quantidade deve ser maior que zero." . PHP_EOL);
    }

    // Tentando remoção de produto existente e inexistente no Carrinho:
    public function testRemoverProdutoExistente(): void {
        $this->carrinho->adicionarProduto($this->produto1, 3);
        $this->carrinho->adicionarProduto($this->produto2, 2);       
        $this->carrinho->removerProduto($this->produto2);        
        $this->assertCount(1, $this->carrinho->getProdutos());
    }

    public function testRemoverProdutoInexistente(): void {        
        $this->carrinho->removerProduto($this->produto3);       
        $this->expectOutputString("Erro ao remover produto do carrinho: Produto não encontrado no carrinho." . PHP_EOL);
    }

    // Testando Calculo de valor total dos produtos no carrinho:
    public function testCalcularTotal(): void {
        $this->carrinho->adicionarProduto($this->produto1, 2);
        $this->carrinho->adicionarProduto($this->produto2, 4);
        $this->carrinho->adicionarProduto($this->produto3, 1);
        $this->assertEquals(100.0, $this->carrinho->calcularTotal());
    }
    
    //Testando mostar produtos do carrinho:
    public function testMostrarProdutos(): void {
        $this->carrinho->adicionarProduto($this->produto1, 3);
        $this->carrinho->adicionarProduto($this->produto2, 2);        
        
        ob_start();
        $this->carrinho->mostrarProdutos();
        $output = ob_get_clean();
        $expectedOutput = "Produto 1 - Quantidade: 3" . PHP_EOL . "Produto 2 - Quantidade: 2" . PHP_EOL;

        // Compara a saída de teste com a saída esperada
        $this->assertEquals($expectedOutput, $output);
    }
}