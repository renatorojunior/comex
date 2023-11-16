<?php

namespace Renato\Comex\Tests\Modelo;

use Renato\Comex\Modelo\{Cliente, Pedido, Produto};
use \ReflectionClass;
use PHPUnit\Framework\TestCase;


class ClienteTest extends TestCase {
    private Cliente $cliente;
    private Produto $produto;
    private Pedido $pedido;    

    protected function setUp(): void {
        $this->cliente = new Cliente('98765432101', 'Renato Rodrigues', 'renato@email.com', '13981597845', 'Rua Exemplo, 13');
        $this->produto = new Produto("001", "Produto Teste", 5.99, 2);
        $this->pedido = new Pedido(1, $this->cliente , ['produto' => $this->produto, 'quantidade' => 2]);          
    }

    //Testando Construtor para criar Cliente
    public function testCriacaoCliente() {
        $this->assertInstanceOf(Cliente::class, $this->cliente);
        $this->assertEquals('98765432101', $this->cliente->getCpf());
        $this->assertEquals('Renato Rodrigues', $this->cliente->getNome());
        $this->assertEquals('renato@email.com', $this->cliente->getEmail());
        $this->assertEquals('(13) 98159-7845', $this->cliente->getCelular());
        $this->assertEquals('Rua Exemplo, 13', $this->cliente->getEndereco());
        $this->assertEquals(0.0, $this->cliente->getTotalCompras());
        $this->assertEmpty($this->cliente->getPedidos());
    }

    //Testando Getters e Setters:
    public function testGetCpf() {
        $this->assertEquals('98765432101', $this->cliente->getCpf());
    }

    public function testGetNome() {
        $this->assertEquals('Renato Rodrigues', $this->cliente->getNome());
    }

    public function testGetEmail() {
        $this->assertEquals('renato@email.com', $this->cliente->getEmail());
    }

    public function testGetCelular() {
        $this->assertEquals('(13) 98159-7845', $this->cliente->getCelular());
    }

    public function testGetEndereco() {
        $this->assertEquals('Rua Exemplo, 13', $this->cliente->getEndereco());
    }

    public function testGetTotalCompras() {
        $this->assertEquals(0.0, $this->cliente->getTotalCompras());
    }

    public function testGetPedidos() {
        $this->assertEmpty($this->cliente->getPedidos());
    }

    public function testSetCpf() {
        $this->cliente->setCpf('12345678900');
        $this->assertEquals('12345678900', $this->cliente->getCpf());
    }    

    public function testSetNome() {
        $this->cliente->setNome('Fulado de Tal');
        $this->assertEquals('Fulado de Tal', $this->cliente->getNome());
    }    

    public function testSetEmail() {
        $this->cliente->setEmail('fulano@email.com');
        $this->assertEquals('fulano@email.com', $this->cliente->getEmail());
    }    

    public function testSetCelular() {
        $this->cliente->setCelular('13974567890');
        $this->assertEquals('(13) 97456-7890', $this->cliente->getCelular()); 
    }    

    public function testSetEndereco() {
        $this->cliente->setEndereco('Avenida das Torres, 85');
        $this->assertEquals('Avenida das Torres, 85', $this->cliente->getEndereco());
    }    

    public function testSetTotalCompras() {
        $this->cliente->setTotalCompras(80.05);
        $this->assertEquals(80.05, $this->cliente->getTotalCompras());
    }    

    public function testSetPedidos() {
        $pedidos = ['Pedido 1', 'Pedido 2'];
        $this->cliente->setPedidos($pedidos);
        $this->assertEquals($pedidos, $this->cliente->getPedidos());
    }
    
    // Testando adição de pedidos:
    public function testAdicionarPedidoComSucesso() {
    
    $this->cliente->adicionarPedido($this->pedido);
    $this->assertContains($this->pedido, $this->cliente->getPedidos());
    }

    public function testAdicionarPedidoDuplicado() {
        $this->cliente->adicionarPedido($this->pedido);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Pedido já existe na lista de pedidos.');
        $this->cliente->adicionarPedido($this->pedido);
    }

    // Testando adição de um pedido nulo:
    public function testAdicionarPedidoComPedidoNulo()
    {        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Pedido inválido. Deve ser uma instância da classe Pedido.");
        $this->cliente->adicionarPedido(null);
    }

    // Testando formatação de numero de celular com regex:
    public function testFormatarNumeroCelularComSucesso() {
        $reflectionClass = new ReflectionClass(Cliente::class);
        $formatarNumeroCelular = $reflectionClass->getMethod('formatarNumeroCelular');
        $formatarNumeroCelular->setAccessible(true);

        $celularFormatado = $formatarNumeroCelular->invokeArgs($this->cliente, ['13981597845']);
        $this->assertEquals('(13) 98159-7845', $celularFormatado);
    }
    
    // Testando Exibição de Dados do Cliente:
    public function testExibirDadosCliente() {        
        ob_start();
        $this->cliente->exibirDadosCliente();
        $output = ob_get_clean();     
        
        $expectedOutput = "Nome: Renato Rodrigues" . PHP_EOL;
        $expectedOutput .= "CPF: 98765432101" . PHP_EOL;
        $expectedOutput .= "E-mail: renato@email.com" . PHP_EOL;
        $expectedOutput .= "Celular: (13) 98159-7845" . PHP_EOL;
        $expectedOutput .= "Endereço: Rua Exemplo, 13" . PHP_EOL;    
        
        $expectedOutput = str_replace(["\r\n", "\r"], "\n", $expectedOutput);
        $output = str_replace(["\r\n", "\r"], "\n", $output);
    
        // Compara a saída do teste com a saída esperada
        $this->assertEquals($expectedOutput, $output);
    } 
    
}