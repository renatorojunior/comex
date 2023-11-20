<?php

namespace Renato\Comex\Infrastructure\Repository;

require_once __DIR__ . '/../../Domain/Repository/OrderRepository.php';

use PDO;
use Renato\Comex\Domain\Model\{Order, Product};
use Renato\Comex\Domain\Repository\OrderRepository;

class PdoOrderRepository implements OrderRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allOrders(): array
    {
        $stmt = $this->connection->query('SELECT * FROM orders');
        $ordersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];
        foreach ($ordersData as $data) {
            $orders[] = $this->createOrderFromData($data);
        }

        return $orders;
    }

    public function findOrdersByClientId(string $clientId): array
    {
        $stmt = $this->connection->prepare('SELECT * FROM orders WHERE client_id = :client_id');
        $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
        $stmt->execute();

        $ordersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];
        foreach ($ordersData as $data) {
            $orders[] = $this->createOrderFromData($data);
        }

        return $orders;
    }

    public function findOrderByNumber(string $number): ?Order
    {
        $stmt = $this->connection->prepare('SELECT * FROM orders WHERE order_number = :order_number');
        $stmt->bindParam(':order_number', $number, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->createOrderFromData($data) : null;
    }

    public function save(Order $order): bool
    {
        $stmt = $this->connection->prepare('INSERT INTO orders (client_id, order_number, total_amount) VALUES (:client_id, :order_number, :total_amount)');
        $stmt->bindParam(':client_id', $order->getClient(), PDO::PARAM_INT);
        $stmt->bindParam(':order_number', $order->getOrderNumber(), PDO::PARAM_STR);
        $stmt->bindParam(':total_amount', $order->getTotalAmount(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function remove(Order $order): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM orders WHERE id = :id');
        $stmt->bindParam(':id', $order->getOrderId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function update(Order $order): bool
    {
        $stmt = $this->connection->prepare('UPDATE orders SET client_id = :client_id, order_number = :order_number, total_amount = :total_amount WHERE id = :id');
        $stmt->bindParam(':id', $order->getOrderId(), PDO::PARAM_INT);
        $stmt->bindParam(':client_id', $order->getClient(), PDO::PARAM_INT);
        $stmt->bindParam(':order_number', $order->getOrderNumber(), PDO::PARAM_STR);
        $stmt->bindParam(':total_amount', $order->getTotalAmount(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Método auxiliar para criar uma instância de Order a partir dos dados do banco
    private function createOrderFromData(array $data): Order
    {
        $order = new Order(
            $data['order_number'],
            $data['client_id'],
            $this->createProductArrayFromData($data['products']),
            (float)$data['total_amount']
        );

        return $order;
    }

    private function createProductArrayFromData(array $productsData): array
    {
        $products = [];

        foreach ($productsData as $productData) {
            $product = new Product(
                $productData['id'],
                $productData['code'],
                $productData['name'],
                (float)$productData['price'],
                (int)$productData['quantity']
            );

            $products[] = ['produto' => $product, 'quantidade' => (int)$productData['quantity']];
        }

        return $products;
    }
}
?>