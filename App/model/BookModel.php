<?php

namespace App\Model;

use PDO;
use PDOException;
/*
    adminFunction
        =>create book
        =>delete book 
        =>update book
    userFunction
        =>newBooks
        =>offersDay
        =>bestSeller
        =>newArrival
        =>getAll
        =>getFour
        =>getById
*/
class BookModel
{
    private $count = 0;

    public function __construct(PDO $pdo)
    {
        $stmt = $pdo->query("SELECT COUNT(product.ProductId) as total_products FROM product ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->count = $rows[0]["total_products"];
    }


    public function newBooks($db)
    {
        $stmt = $db->query("SELECT * from product limit 3");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function getFour($db, $start)
    {
        if ($start <= 0) {
            header("Location: http://localhost/book2/shop.php");
        }
        $offset = ($start - 1) * 4;
        $stmt = $db->query("SELECT product.* , offers.value FROM product LEFT JOIN offers ON(product.ProductId = offers.ProductId) LIMIT 4 OFFSET $offset");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($start > ceil($this->count / 4)) {
            header("Location: http://localhost/book2/shop.php?page=" . ceil($this->count / 4));
        }
        return $rows;
    }

    public function getById($db, $id)
    {
        $stmt = $db->query("SELECT product.* , offers.value as OfferValue FROM product LEFT JOIN offers ON(product.ProductId = offers.ProductId) WHERE product.ProductId = $id");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    public function pages($db)
    {
        return ceil($this->count / 4);
    }
    public function isActive($page, $start)
    {
        return $page == $start ? "active" : "";
    }
}
