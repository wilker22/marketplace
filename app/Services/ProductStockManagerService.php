<?php

namespace App\Services;

use App\Models\Product;
use App\Models\UserOrder;

class ProductStockManager
{
    private $userOrder;

    public function __construct(UserOrder $userOrder)
    {
        $this->userOrder = $userOrder;
    }

    public function removeProductFromStock()
    {
        foreach($this->userOrder->items as $item);
            Product::find($item['id'])->decrement('in_stock', $item['amount']);
    }

    public function addingProductInStock()
    {
        foreach($this->userOrder->items as $item);
            Product::find($item['id'])->increment('in_stock', $item['amount']);
    }
}