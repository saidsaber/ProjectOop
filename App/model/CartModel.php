<?php

namespace App\model;

// require_once "../../vendor/autoload.php";
/*
    addToCart
    removeFromCart
    updateQty
 */
class CartModel
{
    public function addToCart($db, $userId, $productId, $qty)
    {
        $stmt = $db->prepare("INSERT INTO products (UserId,ProductId,HasOrder,Qty) VALUES (?,?,?,?)");
        $stmt->execute([$userId, $productId, 0, $qty]);
    }

}