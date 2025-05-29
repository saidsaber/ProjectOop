<?php

namespace App;

use PDO;

// Properties: id,name,price
// contructor
// Getters: getId(),getName(),getPrice()

/*
 - create():create one product
 - getAll():list all products
 - findById($id):one product
*/

class Product
{
    // Propertiess
    private int $id;
    private string $name;
    private float $price;

    // Contructor
    public function __construct(int $id, string $name, float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    // Create Product
    public static function create(PDO $pdo, string $name, float $price): ?Product
    {
        $stmt = $pdo->prepare("INSERT INTO products (name,price) VALUES (?,?)");
        $success = $stmt->execute([$name, $price]);

        if ($success) {
            $id = (int) $pdo->lastInsertId();
            return new self($id, $name, $price);
        }

        return null;
    }

    // Get All Products
    public static function getAll(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT id,name,price from products");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];

        foreach($rows as $row){
            $products[] = new Product($row['id'],$row['name'],$row['price']);
        }

        return $products;
    }

    // Find One Product By Id
    public static function findById(PDO $pdo , int $id): ?Product
    {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            return new Product($row['id'],$row['name'],$row['price']);
        }

        return null;
    }
}
