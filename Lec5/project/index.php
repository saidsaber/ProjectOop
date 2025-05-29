<?php

require_once "vendor/autoload.php";
require_once "config/database.php";

use App\Product;
use App\Database;

$db = Database::getInstance($config)->getConnection();

// $newProduct = Product::create($db,'fan',50.5);
// var_dump($newProduct);

// echo "<br>";
// echo "<br>";
// echo "<br>";

// $products = Product::getAll($db);
// foreach($products as $product){
//     echo $product->getName() . " - " . $product->getPrice() . "<br>";
// }

// echo "<br>";
// echo "<br>";
// echo "<br>";


$product = Product::findById($db,4);
var_dump($product);