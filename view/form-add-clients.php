<?php

require_once('../config/connection.php');
require_once __DIR__ . '/../src/Infrastructure/Repository/PdoClientRepository.php';
require_once __DIR__ . '/../src/Domain/Model/Client.php';

use Renato\Comex\Infrastructure\Repository\PdoClientRepository;
use Renato\Comex\Domain\Model\Client;

$pdoClientRepository = new PdoClientRepository($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'];
    $clientName = $_POST['client_name'];
    $email = $_POST['email'];
    $cellphone = $_POST['cellphone'];
    $address = $_POST['address'];

    $client = new Client($cpf, $clientName, $email, $cellphone, $address);

    $addClient = $pdoClientRepository->save($client);

    if ($addClient) {
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo 'Erro ao cadastrar cliente.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/add__clients.css">
    <title>Cadastro de Clientes</title>
</head>

<body>
    <div class="container">
        <div class="form-image">
            <img src="./assets/img/add_user.svg" alt="Imagem ilustrativa de processamento de dados.">
        </div>
        <div class="form-register">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-title">
                    <h2>Cadastro de Clientes</h2>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="cpf">CPF:</label>
                        <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF" required>
                    </div>

                    <div class="input-box">
                        <label for="client_name">Nome do Cliente:</label>
                        <input type="text" id="client_name" name="client_name" placeholder="Digite o nome do cliente" required>
                    </div>

                    <div class="input-box">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" placeholder="Digite o e-mail" required>
                    </div>

                    <div class="input-box">
                        <label for="cellphone">Número de Celular:</label>
                        <input type="tel" id="cellphone" name="cellphone" placeholder="Digite o número" required>
                    </div>
                    <div class="input-box">
                        <label for="address">Endereço:</label>
                        <input type="text" id="address" name="address" placeholder="Digite o endereço" required>
                    </div>
                </div>
                <div class="submit-button">
                    <input type="submit" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
</body>

</html>