<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . '/book2/vendor/autoload.php');

namespace App\Controller;
// include($_SERVER['DOCUMENT_ROOT'] . '/book2/App/model/Config.php');

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
class BookController
{
    private static $count = 0;
    private $ProductId;
    private $SCateId;
    private $CateId;
    private $BrandId;
    private $AdminId;
    private $lang;
    private $ProductName;
    private $ProductDescription;
    private $ProductPrice;
    private $ProductQty;
    private $Image;
    private $OfferValue;

    public function __construct(PDO $pdo, $ProductId, $SCateId, $CateId, $BrandId, $AdminId, $lang, $ProductName, $ProductDescription, $ProductPrice, $ProductQty, $Image, $OfferValue)
    {
        $this->ProductId = $ProductId;
        $this->SCateId = $SCateId;
        $this->CateId = $CateId;
        $this->BrandId = $BrandId;
        $this->AdminId = $AdminId;
        $this->lang = $lang;
        $this->ProductName = $ProductName;
        $this->ProductDescription = $ProductDescription;
        $this->ProductPrice = $ProductPrice;
        $this->ProductQty = $ProductQty;
        $this->Image = $Image;
        $this->OfferValue = $OfferValue;
    }

    public static function setCount(PDO $pdo)
    {
        $stmt = $pdo->query("SELECT COUNT(product.ProductId) as total_products FROM product ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        self::$count = $rows[0]["total_products"];
        return ceil(self::$count / 4);
    }
    public function newBooks($db)
    {
        $stmt = $db->query("SELECT * from product limit 3");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function getProductId()
    {
        return $this->ProductId;
    }

    public function getSCateId()
    {
        return $this->SCateId;
    }

    public function getCateId()
    {
        return $this->CateId;
    }

    public function getBrandId()
    {
        return $this->BrandId;
    }

    public function getAdminId()
    {
        return $this->AdminId;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function getProductName()
    {
        return $this->ProductName;
    }

    public function getProductDescription()
    {
        return $this->ProductDescription;
    }

    public function getProductPrice()
    {
        return $this->ProductPrice;
    }

    public function getProductQty()
    {
        return $this->ProductQty;
    }

    public function getImage()
    {
        return $this->Image;
    }

    public function getOfferValue()
    {
        return $this->OfferValue;
    }

    public static function getnew($db)
    {
        $stmt = $db->query("SELECT product.* , offers.value as OfferValue FROM product LEFT JOIN offers ON(product.ProductId = offers.ProductId) LIMIT 5");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $books = [];
        foreach ($rows as $row) {
            $books[] = new self($db, $row['ProductId'], $row['SCateId'], $row['CateId'], $row['BrandId'], $row['AdminId'], $row['lang'], $row['ProductName'], $row['ProductDescription'], $row['ProductPrice'], $row['ProductQty'], $row['Image'], $row['OfferValue']);
        }
        return $books;
    }

    public static function getOffer($db)
    {
        $stmt = $db->query("SELECT product.*, offers.value AS OfferValue FROM product LEFT JOIN offers ON product.ProductId = offers.ProductId WHERE offers.value > 0 ORDER BY product.MostCommon DESC LIMIT 5");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $books = [];
        foreach ($rows as $row) {
            $books[] = new self($db, $row['ProductId'], $row['SCateId'], $row['CateId'], $row['BrandId'], $row['AdminId'], $row['lang'], $row['ProductName'], $row['ProductDescription'], $row['ProductPrice'], $row['ProductQty'], $row['Image'], $row['OfferValue']);
        }
        return $books;
    }
    public static function getMostCommon($db)
    {
        $stmt = $db->query("SELECT product.* , offers.value as OfferValue FROM product LEFT JOIN offers ON(product.ProductId = offers.ProductId) ORDER BY product.MostCommon DESC LIMIT 5;");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $books = [];
        foreach ($rows as $row) {
            $books[] = new self($db, $row['ProductId'], $row['SCateId'], $row['CateId'], $row['BrandId'], $row['AdminId'], $row['lang'], $row['ProductName'], $row['ProductDescription'], $row['ProductPrice'], $row['ProductQty'], $row['Image'], $row['OfferValue']);
        }
        return $books;
    }
    public static function getFour($db, $start)
    {
        if ($start <= 0) {
            header("Location: http://localhost/book2/shop.php");
        }
        $offset = ($start - 1) * 4;
        $stmt = $db->query("SELECT product.* , offers.value as OfferValue FROM product LEFT JOIN offers ON(product.ProductId = offers.ProductId) LIMIT 4 OFFSET $offset");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $books = [];
        if ($start > ceil(num: self::$count / 4)) {
            header("Location: http://localhost/book2/shop.php?page=" . ceil(self::$count / 4));
        }
        foreach ($rows as $row) {
            $books[] = new self($db, $row['ProductId'], $row['SCateId'], $row['CateId'], $row['BrandId'], $row['AdminId'], $row['lang'], $row['ProductName'], $row['ProductDescription'], $row['ProductPrice'], $row['ProductQty'], $row['Image'], $row['OfferValue']);
        }
        return $books;
    }
    public static function getFourLang($db, $start , $lang)
    {
        if ($start <= 0) {
            header("Location: http://localhost/book2/shop.php");
        }
        $offset = ($start - 1) * 4;
        $stmt = $db->query("SELECT product.* , offers.value as OfferValue FROM product LEFT JOIN offers ON(product.ProductId = offers.ProductId) where lang = '$lang' LIMIT 4 OFFSET $offset");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $books = [];
        if ($start > ceil(num: self::$count / 4)) {
            header("Location: http://localhost/book2/shop.php?page=" . ceil(self::$count / 4));
        }
        foreach ($rows as $row) {
            $books[] = new self($db, $row['ProductId'], $row['SCateId'], $row['CateId'], $row['BrandId'], $row['AdminId'], $row['lang'], $row['ProductName'], $row['ProductDescription'], $row['ProductPrice'], $row['ProductQty'], $row['Image'], $row['OfferValue']);
        }
        return $books;
    }

    public static function getById($db, $id)
    {
        $stmt = $db->query("SELECT product.*, offers.value AS OfferValue FROM product LEFT JOIN offers ON product.ProductId = offers.ProductId WHERE product.ProductId = $id");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $books = [];
        foreach ($rows as $row) {
            $books = new self($db, $row['ProductId'], $row['SCateId'], $row['CateId'], $row['BrandId'], $row['AdminId'], $row['lang'], $row['ProductName'], $row['ProductDescription'], $row['ProductPrice'], $row['ProductQty'], $row['Image'], $row['OfferValue']);
        }
        return $books;
    }
    public static function isActive($page, $start)
    {
        return $page == $start ? "active" : "";
    }

    public function getPrice()
    {
        if (!empty($this->OfferValue)) {
            echo '
              <span class="product__price product__price--old fs-6 ">
                ' . $this->ProductPrice . ' جنيه
              </span>
              <span class="product__price fs-5">
                ' . $this->ProductPrice - ($this->OfferValue / 100 * $this->ProductPrice) . ' جنيه
              </span>
              ';
        } else {
            echo '
              <span class="product__price fs-5">
                ' . $this->ProductPrice . ' جنيه
              </span>
              ';
        }
    }
}