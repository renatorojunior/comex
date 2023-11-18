<?php

namespace Renato\Comex\Domain\Repository;

use Renato\Comex\Domain\Model\Client;

interface ClientRepository
{
    public function allClients(): array;
    public function findClientById(string $clientId): ?Client;
    public function findByCpf(string $cpf): ?Client;    
    public function save(Client $client): bool;
    public function remove(Client $client): bool;
    public function update(Client $client): bool;
}

?>