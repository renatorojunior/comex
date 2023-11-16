<?php

namespace Renato\Comex\Tests\Modelo;

use Renato\Comex\Modelo\{Produto};
use Renato\Comex\Exception\NotFoundProductException;
use PHPUnit\Framework\TestCase;

class ProdutoTest extends TestCase {

    private $produto;    

    public function setUp(): void {
        $this->produto = new Produto('001', 'Produto Teste', 100.0, 10);
    }

    // Testando inicialização dos Produtos
    public function testConstrutorProduto() {        
        $this->assertEquals('001', $this->produto->getCodigo());
        $this->assertEquals('Produto Teste',  $this->produto->getNome());
        $this->assertEquals(100.0,  $this->produto->getPreco());
        $this->assertEquals(10,  $this->produto->getQuantidadeEstoque());
    } 
    
    // Testanto alterações de atributos com setters:
    public function testSetCodigo() {        
        $this->produto->setCodigo('002');
        $this->assertEquals('002', $this->produto->getCodigo());
    }
    
    public function testSetNome() {
        $this->produto->setNome('Novo Nome');
        $this->assertEquals('Novo Nome', $this->produto->getNome());
    }
    
    public function testSetPreco() {
        $this->produto->setPreco(45.0);
        $this->assertEquals(45.0, $this->produto->getPreco());
    }
    
    public function testSetQuantidadeEstoque() {
        $this->produto->setQuantidadeEstoque(5);
        $this->assertEquals(5, $this->produto->getQuantidadeEstoque());
    }

    //Testando adição e remoção de produtos:
    public function testAdicionarProdutoComQuantidadePositiva() {        
        $this->produto->adicionarProduto('001', 5);
        $this->assertEquals(15, $this->produto->getQuantidadeEstoque());
    }

    public function testRemoverProdutoComQuantidadePositiva() {
        
        $this->produto->removerProduto('001', 3);
        $this->assertEquals(7, $this->produto->getQuantidadeEstoque());
    }

    //Testando adição e remoção de produtos com quantidade inválida:
    public function testAdicionarProdutoComQuantidadeInvalida() {
        //Testando adição de Produto com quantidade negativa.        
        $this->expectException(\InvalidArgumentException::class);        
        $this->produto->adicionarProduto('001', -5);

        //Testando adição de Produto com quantidade igual a 0.
        $this->expectException(\InvalidArgumentException::class);        
        $this->produto->adicionarProduto('001', 0);
    }
    
    public function testRemoverProdutoComQuantidadeInvalida() {
        //Testando remoção de Produto com quantidade negativa.
        $this->expectException(\InvalidArgumentException::class);        
        $this->produto->removerProduto('001', -5);
        
        //Testando remoção de Produto com quantidade igual a 0.
        $this->expectException(\InvalidArgumentException::class);        
        $this->produto->removerProduto('001', 0);
    }

    //Testando adição e remoção de produtos com código inválido:
    public function testAdicionarProdutoComCodigoInvalido() {
        $this->expectException(\InvalidArgumentException::class);
        $this->produto->adicionarProduto('002', 5);
    }
    
    public function testRemoverProdutoComCodigoInvalido() {
        $this->expectException(\InvalidArgumentException::class);
        $this->produto->removerProduto('002', 3);
    }    
    
    // Testando remoção de produto com quantidade maior que estoque: 
    public function testRemoverProdutoComQuantidadeMaiorQueEstoque() {            
        $this->expectException(\InvalidArgumentException::class);
        $this->produto->removerProduto('001', 15);
    }

    // Testando calculo de valor total do produto em estoque: 
    public function testCalcularValorTotal() {        
        $this->assertEquals(1000.0, $this->produto->calcularValorTotal());
    }

    // Testando exibir estoque de produto Existente e Inexistente: 
    public function testExibirEstoqueParaProdutoExistente() {
      
        $expectedOutput = "Produto: Produto Teste. Quantidade em Estoque: 10\n";
        
        ob_start();
        $this->produto->exibirEstoque('001');
        $actualOutput = ob_get_clean();
        
        $expectedOutput = str_replace("\r\n", "\n", $expectedOutput);
        $actualOutput = str_replace("\r\n", "\n", $actualOutput);
        
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testExibirEstoqueParaProdutoInexistente() {        
        $this->expectException(NotFoundProductException::class);
        $this->produto->exibirEstoque('002');
    }
}

?>