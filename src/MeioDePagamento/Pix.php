<?php

namespace Renato\Comex\MeioDePagamento;

use Renato\Comex\Modelo\{Cliente};
use Exception;

// Implementação da classe para Pagamento via Pix
class Pix implements MeioDePagamento {
    private Cliente $cliente;

    public function __construct(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    public function processarPagamento(float $valor) {
        try {
            echo "Processando pagamento..." . PHP_EOL;

            sleep(5); // Simula um processamento de pagamento
            
            $pagamento = rand(0, 1); // 0: pagamento recusado, 1: pagamento aprovado

            if ($pagamento === 1) {
                echo "O pagamento de R$ " . number_format($valor, 2, ',', '.') . " via Pix do cliente " . $this->cliente->getNome() . " foi processado com sucesso." . PHP_EOL;
            } else {
                throw new Exception("Pagamento não confirmado. Tente novamente mais tarde.");
            }
        } catch (Exception $e) {
            echo "Erro ao processar pagamento: " . $e->getMessage() . PHP_EOL;
        }
    }
}

?>