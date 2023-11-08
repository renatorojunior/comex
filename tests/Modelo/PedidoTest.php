<?php

namespace Renato\Comex\Tests\Modelo;

use Renato\Comex\Modelo\{Cliente, Produto, Pedido};
use PHPUnit\Framework\TestCase;

class PedidoTest extends TestCase {
    private Cliente $cliente;
    private Produto $produto1;
    private Produto $produto2;
    private Produto $produto3;
    private array $produtos;
    private Pedido $pedido;

    protected function setUp(): void {
        $this->cliente = new Cliente("95172378912", "Cliente Teste", "cliente@teste.com", "13981594815", "Endereço Teste");
        $this->produto1 = new Produto("001", "Produto 1", 10.00, 5);
        $this->produto2 = new Produto("002", "Produto 2", 15.00, 10);
        $this->produto3 = new Produto("003", "Produto 3", 20.00, 8);  
        $this->produtos = [$this->produto1, $this->produto2, $this->produto3];
        $this->pedido = new Pedido(1, $this->cliente, $this->produtos);          
    }
    
    // Testando inicialização do Construtor Pedido:
    public function testConstrutorPedido() {                       
        $this->assertInstanceOf(Pedido::class, $this->pedido);
        $this->assertEquals(1, $this->pedido->getId());
        $this->assertInstanceOf(Cliente::class, $this->pedido->getCliente());
        $this->assertEquals($this->produtos, $this->pedido->getProdutos());
    }

    //Testando Getters:
    public function testGetId(): void {
        $this->assertEquals(1, $this->pedido->getId());
    }

    public function testGetCliente(): void {
        $this->assertInstanceOf(Cliente::class, $this->pedido->getCliente());
    }

    public function testGetProdutos(): void {
        $this->assertEquals($this->produtos, $this->pedido->getProdutos());
    }

    public function testGetNome(): void {
        $this->assertEquals("Produto 1", $this->produto1->getNome());
        $this->assertEquals("Produto 2", $this->produto2->getNome());
        $this->assertEquals("Produto 3", $this->produto3->getNome());
    }

    public function testGetPreco(): void {
        $this->assertEquals(10.00, $this->produto1->getPreco());
    }

    public function testGetQuantidadeEstoque(): void {
        $this->assertEquals(5, $this->produto1->getQuantidadeEstoque());
        $this->assertEquals(10, $this->produto2->getQuantidadeEstoque());
        $this->assertEquals(8, $this->produto3->getQuantidadeEstoque());
    }

    public function testSetCodigo(): void {
        $this->produto1->setCodigo("004");
        $this->assertEquals("004", $this->produto1->getCodigo());
    }

    public function testSetNome(): void {
        $this->produto1->setNome("Produto 4");
        $this->assertEquals("Produto 4", $this->produto1->getNome());
    }

    public function testSetPreco(): void {
        $this->produto1->setPreco(15.00);
        $this->assertEquals(15.00, $this->produto1->getPreco());
    }

    public function testSetQuantidadeEstoque(): void {
        $this->produto1->setQuantidadeEstoque(10);
        $this->assertEquals(10, $this->produto1->getQuantidadeEstoque());

        $this->produto2->setQuantidadeEstoque(5);
        $this->assertEquals(5, $this->produto2->getQuantidadeEstoque());

        $this->produto3->setQuantidadeEstoque(20);
        $this->assertEquals(20, $this->produto3->getQuantidadeEstoque());
    }

    //Testando adicionar produto ao pedido:
    public function testAdicionarProdutoAoPedido() {        
        $pedido2 = new Pedido(2, $this->cliente, []);
                
        $pedido2->adicionarProduto($this->produto1, 2);
        $this->assertCount(1, $pedido2->getProdutos());
        
        $pedido2->adicionarProduto($this->produto2, 3);
        $this->assertCount(2, $pedido2->getProdutos());

        $pedido2->adicionarProduto($this->produto1, 1);
        $this->assertCount(2, $pedido2->getProdutos());
        
        $produto4 = new Produto("004", "Produto 4", 15.00, 5);
        $pedido2->adicionarProduto($produto4, 1);
        $this->assertCount(3, $pedido2->getProdutos());

        $pedido2->adicionarProduto($this->produto3, 1);
        $this->assertCount(4, $pedido2->getProdutos());
    }

    // Testando Calcula Valor Total do Pedido
    public function testCalcularValorTotal(): void {
        
        $produtos = [
            ['produto' => $this->produto1, 'quantidade' => 2],
            ['produto' => $this->produto2, 'quantidade' => 3]
        ];

        $pedido1 = new Pedido(1, $this->cliente, $produtos);

        // O valor total deve ser (10.00 * 2) + (15.00 * 3) = 65.00
        $this->assertEquals(65.00, $pedido1->calcularValorTotal());
    }
}

?>