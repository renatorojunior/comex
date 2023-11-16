<?php

namespace Renato\Comex\MeioDePagamento;

use Renato\Comex\Modelo\{Cliente};
use InvalidArgumentException, LogicException;

// Implementação da classe para Pagamento via Cartão de Crédito
class CartaoDeCredito implements MeioDePagamento {
    private string $numeroCartao;
    private Cliente $cliente;
    private string $senha;

    public function __construct(string $numeroCartao, Cliente $cliente, string $senha) {
        $this->numeroCartao = $numeroCartao;
        $this->cliente = $cliente;
        $this->senha = $senha;
    }

    public function processarPagamento(float $valor): bool {
        $tentativas = 3;
        
        while ($tentativas > 0) {
            try {
                // Simula validação de senha                
                $randomNumber = rand(0, 1);
                $senhaDigitada = ($randomNumber === 1) ? "123" : "321";
    
                if ($senhaDigitada !== $this->senha) {
                    throw new \InvalidArgumentException("Pagamento recusado. Senha incorreta.");
                }
                
                // Simula um processamento de pagamento               
                $pagamento = rand(0, 1);
    
                if ($pagamento === 1) {
                    return true; // Pagamento bem-sucedido
                } else {
                    throw new \LogicException("Pagamento recusado pelo seu banco.");
                }
            } catch (\InvalidArgumentException $e) {                
                throw $e;
            } catch (\LogicException $e) {                
                throw $e;
            }
        
            $tentativas--;
        }
        
        return false; // Número máximo de tentativas excedido, o pagamento foi recusado
    }
}    

?>