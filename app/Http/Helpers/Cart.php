<?php

namespace App\Http\Helpers;

class Cart
{
  // public static function getCartItemsCount()
  // {
  //   $cartItems = self::getCartItems();
  //   return array_reduce($cartItems, fn($carry, $item) => $carry + $item['quantity'], 0);
  // }
  public static function getCartItemsCount()
  {
    $cartItems = self::getCartItems();
    return count($cartItems);
  }

  public static function getCartItems()
  {
    $request = request();
    return json_decode($request->cookie('cart_items', '[]') , true);
  }

  // public static function getCountFromItems($cartItems)
  // {
  //   return array_reduce($cartItems, fn($carry, $item) => $carry + $item['quantity'], 0);
  // }
  public static function getCountFromItems($cartItems)
  {
    return count($cartItems);
  }
}