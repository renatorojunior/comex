<?php

namespace Renato\Comex\Infrastructure\Repository;

require_once __DIR__ . '/../../Domain/Repository/ClientRepository.php';

use PDO;
use Renato\Comex\Domain\Model\Client;
use Renato\Comex\Domain\Repository\ClientRepository;

class PdoClientRepository implements ClientRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
    
    public function allClients(): array
    {
        $stmt = $this->connection->query("SELECT * FROM clients");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findClientById(string $clientId): ?Client
    {
        $stmt = $this->connection->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->execute([$clientId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($data) ? new Client($data['id'], $data['cpf'], $data['client_name'], $data['email'], $data['cellphone'], $data['address']) : null;
    }

    public function findByCpf(string $cpf): ?Client
    {
        $stmt = $this->connection->prepare("SELECT * FROM clients WHERE cpf = ?");
        $stmt->execute([$cpf]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($data) ? new Client($data['id'], $data['cpf'], $data['client_name'], $data['email'], $data['cellphone'], $data['address']) : null;
    }     

    public function save(Client $client): bool
    {
        $stmt = $this->connection->prepare("INSERT INTO clients (cpf, client_name, email, cellphone, address) VALUES (?, ?, ?, ?, ?)");

        return $stmt->execute([
            $client->getCpf(),
            $client->getClientName(),
            $client->getClientEmail(),
            $client->getCellphone(),
            $client->getAddress(),
        ]);
    }

    public function remove(Client $client): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM clients WHERE id = ?");
        return $stmt->execute([$client->getClientId()]);
    }

    public function update(Client $client): bool
    {
        $stmt = $this->connection->prepare("UPDATE clients SET cpf = ?, client_name = ?, email = ?, cellphone = ?, address = ? WHERE id = ?");

        return $stmt->execute([
            $client->getClientId(),
            $client->getCpf(),
            $client->getClientName(),
            $client->getClientEmail(),
            $client->getCellphone(),
            $client->getAddress(),
        ]);
    }
}
