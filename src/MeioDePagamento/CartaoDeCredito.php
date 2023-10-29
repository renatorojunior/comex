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

    public function processarPagamento(float $valor) {
        $tentativas = 3;
    
        while ($tentativas > 0) {
            try {
                echo "Aguarde validação de senha." . PHP_EOL;
                
                sleep(3); // Simula validação de senha                
                $randomNumber = rand(0, 1);
                $randomNumber *= 10;
                $randomNumber = round($randomNumber);
                $senhaDigitada = ($randomNumber < 5) ? "123" : "321";

                if ($senhaDigitada !== $this->senha) {
                    throw new InvalidArgumentException("Pagamento recusado. Senha incorreta.");
                }
                
                echo "Processando pagamento..." . PHP_EOL;
    
                sleep(5); // Simula um processamento de pagamento
                
                $pagamento = rand(0, 1); // Simula resultado da verificação (0: pagamento recusado, 1: pagamento aprovado)
    
                if ($pagamento === 1) {
                    echo "Pagamento de R$ " . number_format($valor, 2, ',', '.') . " via Cartão de Crédito (**** **** **** " . substr($this->numeroCartao, -4) . ") em nome de " . $this->cliente->getNome() . " foi processado com sucesso." . PHP_EOL;
                    return; // Pagamento bem-sucedido, sai do loop
                } else {
                    throw new LogicException("Pagamento recusado pelo seu banco.");
                }
            } catch (InvalidArgumentException $e) {
                echo "Erro ao processar pagamento: " . $e->getMessage() . PHP_EOL;
            } catch (LogicException $e) {
                echo "Erro ao processar pagamento: " . $e->getMessage() . PHP_EOL;
            }
    
            $tentativas--;
        }
    
        echo "Número máximo de tentativas excedido. O pagamento foi recusado." . PHP_EOL;
    }
}    

?>