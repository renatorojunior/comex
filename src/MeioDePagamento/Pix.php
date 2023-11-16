<?php

namespace Renato\Comex\MeioDePagamento;

use Renato\Comex\Modelo\{Cliente};
use Exception;

// Implementação da classe para Pagamento via Pix
class Pix implements MeioDePagamento {
    private Cliente $cliente;
    private MeioDePagamento $meioDePagamento;

    public function __construct(Cliente $cliente, MeioDePagamento $meioDePagamento) {
        $this->cliente = $cliente;
        $this->meioDePagamento = $meioDePagamento;
    }

    public function processarPagamento(float $valor) {
        try {
            echo "Processando pagamento..." . PHP_EOL;
            
            $this->meioDePagamento->processarPagamento($valor);

            echo "O pagamento de R$ " . number_format($valor, 2, ',', '.') . " via Pix do cliente " . $this->cliente->getNome() . " foi processado com sucesso." . PHP_EOL;
        } catch (Exception $e) {
            echo "Erro ao processar pagamento: " . $e->getMessage() . PHP_EOL;
        }
    }
}

?>