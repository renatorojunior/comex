<?php

namespace Renato\Comex\Tests\MeioDePagamento;

use Renato\Comex\Modelo\Cliente;
use Renato\Comex\MeioDePagamento\{MeioDePagamento, Pix};
use PHPUnit\Framework\TestCase;

class MeioDePagamentoTest extends TestCase
{
    public function testProcessarPagamentoComSucesso()
    {
        // Criando um mock da interface MeioDePagamento
        $mockMeioDePagamento = $this->createMock(MeioDePagamento::class);
        
        $mockMeioDePagamento->expects($this->once())
            ->method('processarPagamento')
            ->with(500.00);
        
        $cliente = new Cliente('98765432101', 'Renato Rodrigues', 'renato@email.com', '13981597845', 'Rua Exemplo, 13');

        // Criando uma instância da classe Pix 
        $pix = new Pix($cliente, $mockMeioDePagamento);

        // Processando Pagamento
        $pix->processarPagamento(500.00);
   }    
}

?>





