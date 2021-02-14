<?php

namespace App\Services;

class OrderService{

    /**
     * $order
     */
    public function computeTotalAmount($order){
        $products = $order->products;
        return $products->sum(function ($product) {
            return ($product->qty * $product->price) + $product->tax_amount;
        });
    }
}