<?php

namespace Renato\Comex\Domain\Model;

use InvalidArgumentException, LogicException;

//Classe Cliente
class Client {
    private string $id;
    private string $cpf;
    private string $name;
    private string $email;
    private string $cellphone;
    private string $address;
    private float $totalCompras;
    private array $orders;

    public function __construct(string $cpf, string $name, string $email, string $cellphone, string $address) {
        $this->cpf = $cpf;
        $this->name = $name;
        $this->email = $email;
        $this->cellphone = $this->formatCellphone($cellphone);
        $this->address = $address;
        $this->totalCompras = 0.0;
        $this->orders = [];
    }

    //Getters e Setters
    public function getClientId(): string {
        return $this->id;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void {
        $this->cpf = $cpf;
    }

    public function getClientName(): string {
        return $this->name;
    }

    public function setClientName(string $name): void {
        $this->name = $name;
    }

    public function getClientEmail(): string {
        return $this->email;
    }

    public function setClientEmail(string $email): void {
        $this->email = $email;
    }

    public function getCellphone(): string {
        return $this->cellphone;
    }

    public function setCelular(string $cellphone): void {
        // Formatar o número de celular antes de atribuir à propriedade
        $this->cellphone = $this->formatCellphone($cellphone);
    }

    public function getaddress(): string {
        return $this->address;
    }

    public function setaddress(string $address): void {
        $this->address = $address;
    }

    public function getTotalCompras(): float {
        return $this->totalCompras;
    }

    public function setTotalCompras(float $totalCompras): void {
        $this->totalCompras = $totalCompras;
    }

    public function getPedidos(): array {
        return $this->orders;
    }

    public function setPedidos(array $orders): void {
        $this->orders = $orders;
    }

    // Método para adicionar um pedido à lista de pedidos do cliente com tratamento de Exceções
    public function addOrder(?Order $order): void {
        if ($order === null) {
            throw new InvalidArgumentException("Pedido inválido. Deve ser uma instância da classe Pedido.");
        }
    
        // Verifica se o pedido já existe na lista de pedidos
        foreach ($this->orders as $o) {
            if ($o->getOrderId() === $order->getOrderId()) {
                throw new InvalidArgumentException("Pedido já existe na lista de pedidos.");
            }
        }
    
        // Se não existir, adiciona o novo pedido à lista
        $this->orders[] = $order;
    }
    

    // Método para formatar o número de celular usando regex com tratamento de Exceções
    private function formatCellphone(string $cellphone): string {
        try {
            // Remove caracteres não numéricos do número de celular
            $cellphoneInserted = preg_replace('/\D/', '', $cellphone);

            // Aplica a máscara usando regex
            if (preg_match('/^(\d{2})(\d{5})(\d{4})$/', $cellphoneInserted, $matches)) {
                return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
            }

            // Se o número de celular não corresponder ao padrão, lança uma exceção
            throw new LogicException("Número de celular inválido.");
        } catch (LogicException $e) {
            echo "Erro ao formatar número de celular: " . $e->getMessage() . PHP_EOL;
            return $cellphone; // Retorna o número original em caso de erro
        }
    }

    //Exibir Detalhes do Cliente
    public function exibirDadosCliente(): void {
        echo "name: {$this->name}" . PHP_EOL;
        echo "CPF: {$this->cpf}" . PHP_EOL;
        echo "E-mail: {$this->email}" . PHP_EOL;
        echo "Celular: {$this->cellphone}" . PHP_EOL;
        echo "Endereço: {$this->address}" . PHP_EOL;
    }
}

?>
