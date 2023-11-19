<?php

$databasePath = __DIR__ . '/../database/database.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$createTableSql = '
    CREATE TABLE IF NOT EXISTS clients (
        id INTEGER PRIMARY KEY,
        cpf TEXT,
        client_name TEXT,
        email TEXT,
        cellphone TEXT,
        address TEXT
    );    

    CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY,
        product_code TEXT,
        product_name TEXT,
        price TEXT,
        stock_quantity INTEGER        
    );

    CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY,
        value TEXT,
        client_id INTEGER, 
        product_id INTEGER,        
        FOREIGN KEY(client_id) REFERENCES clients(id),
        FOREIGN KEY(product_id) REFERENCES products(id)
    );
';

$pdo->exec($createTableSql);

?>