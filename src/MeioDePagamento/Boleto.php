<?php

namespace Renato\Comex\MeioDePagamento;

use Renato\Comex\Modelo\{Cliente};
use Exception;

// Implementação da classe para Pagamento via Pix
class Boleto implements MeioDePagamento {
    private Cliente $cliente;
    private bool $vencido;

    public function __construct(Cliente $cliente, $vencido) {
        $this->cliente = $cliente;
        $this->vencido = $vencido;
    }

    public function processarPagamento(float $valor) {
        try {
            echo "Processando pagamento..." . PHP_EOL;

            sleep(1); // Simula um processamento de pagamento            

            $pagamento = rand(0, 1); // 0: pagamento recusado, 1: pagamento aprovado

            if ($this->vencido) {
                $valor += $valor * 0.10; // Acréscimo de 10% se o boleto estiver vencido
                echo "Boleto vencido. Foi adicionado um acréscimo de 10% ao valor do boleto." . PHP_EOL;
                echo "O pagamento do Boleto de R$ " . number_format($valor, 2, ',', '.') . " do cliente " . $this->cliente->getNome() . " foi processado com sucesso." . PHP_EOL;
            } elseif ($pagamento === 1) {
                echo "O pagamento do Boleto de R$ " . number_format($valor, 2, ',', '.') . " do cliente " . $this->cliente->getNome() . " foi processado com sucesso." . PHP_EOL;
            } else {
                throw new Exception("Pagamento não confirmado. Tente novamente mais tarde.");
            }
        } catch (Exception $e) {
            echo "Erro ao processar pagamento: " . $e->getMessage() . PHP_EOL;
        }
    }
}

?>