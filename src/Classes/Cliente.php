<?php

namespace Renato\Comex\Classes;

// Desenvolvendo a Classe Cliente
class Cliente {
    private string $cpf;
    private string $nome;
    private string $email;
    private string $celular;
    private string $endereco;
    private float $totalCompras;
    private array $pedidos;

    public function __construct(string $cpf, string $nome, string $email, string $celular, string $endereco) {
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->email = $email;
        $this->celular = $this->formatarNumeroCelular($celular);
        $this->endereco = $endereco;
        $this->totalCompras = 0.0;
        $this->pedidos = [];
    }

    // Implementando Getters e Setters
    public function getCpf(): string {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void {
        $this->cpf = $cpf;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getCelular(): string {
        return $this->celular;
    }

    public function setCelular(string $celular): void {
        // Formatar o número de celular antes de atribuir à propriedade
        $this->celular = $this->formatarNumeroCelular($celular);
    }

    public function getEndereco(): string {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): void {
        $this->endereco = $endereco;
    }

    public function getTotalCompras(): float {
        return $this->totalCompras;
    }

    public function setTotalCompras(float $totalCompras): void {
        $this->totalCompras = $totalCompras;
    }

    // Getter e Setter para o atributo de pedidos
    public function getPedidos(): array {
        return $this->pedidos;
    }

    public function setPedidos(array $pedidos): void {
        $this->pedidos = $pedidos;
    }

    // Método para adicionar um pedido à lista de pedidos do cliente
    public function adicionarPedido(Pedido $pedido): void {
        $this->pedidos[] = $pedido;
    }

    // Método para formatar o número de celular usando regex
    private function formatarNumeroCelular(string $celular): string {
        // Remove caracteres não numéricos do número de celular
        $celularNumerico = preg_replace('/\D/', '', $celular);

        // Aplica a máscara usando regex
        if (preg_match('/^(\d{2})(\d{5})(\d{4})$/', $celularNumerico, $matches)) {
            return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
        }

        // Se o número de celular não corresponder ao padrão, retorna o número original
        return $celular;
    }

    //Exibir Detalhes do Cliente
    public function exibirDadosCliente(): void {
        echo "Nome: {$this->nome}" . PHP_EOL;
        echo "CPF: {$this->cpf}" . PHP_EOL;
        echo "E-mail: {$this->email}" . PHP_EOL;
        echo "Celular: {$this->celular}" . PHP_EOL;
        echo "Endereço: {$this->endereco}" . PHP_EOL;
    }
}

?>
