<?php

namespace Renato\Comex\Domain\Repository;

use Renato\Comex\Domain\Model\Order;

interface OrderRepository
{
    public function allOrders(): array;
    public function findOrdersByClientId(string $clientId): array;
    public function findOrderByNumber(string $number): ?Order;
    public function save(Order $order): bool;
    public function remove(Order $order): bool;
    public function update(Order $order): bool;
}

?>