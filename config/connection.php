<?php

$databasePath = __DIR__ . '/../database/database.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$createTableSql = '
    CREATE TABLE IF NOT EXISTS clients (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        cpf TEXT NOT NULL,
        client_name TEXT NOT NULL,
        email TEXT NOT NULL,
        cellphone TEXT NOT NULL,
        address TEXT NOT NULL
    );    

    CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        product_code TEXT NOT NULL,
        product_name TEXT NOT NULL,
        price INTEGER NOT NULL,
        stock_quantity INTEGER        
    );
    
    CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        product_id INTEGER NOT NULL,
        quantity INTEGER NOT NULL,
        total_price INTEGER NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (product_id) REFERENCES products(id)
    );       

';

$pdo->exec($createTableSql);
