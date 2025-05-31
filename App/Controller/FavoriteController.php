<?php
// SELECT product.* , offers.value as OfferValue , favorite.* , user.UserId FROM product LEFT JOIN offers ON(product.ProductId = offers.ProductId) LEFT JOIN favorite ON(favorite.ProductId = product.ProductId) LEFT JOIN user ON(favorite.UserId = user.UserId);
