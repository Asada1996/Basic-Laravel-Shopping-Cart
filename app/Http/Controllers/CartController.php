<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
    * Initilise cart
    *
    */
    public function __construct() {
      $this->products = [
       [ "name" => "Sledgehammer", "price" => 125.75 ],
       [ "name" => "Axe", "price" => 190.50 ],
       [ "name" => "Bandsaw", "price" => 562.131 ],
       [ "name" => "Chisel", "price" => 12.9 ],
       [ "name" => "Hacksaw", "price" => 18.45 ],
      ];

  		if(!session('cart_products')) {
  			session(['cart_products' => array()]);
      }
  	}

    /**
     * Show products and cart
     *
     * @return view
     */
    public function index()
    {
        return view('products', ['products' => $this->products, 'cart_products' => session('cart_products'), 'overall_total' => array_sum(array_column(session('cart_products'),'total'))]);
    }

    /**
     * Add product to cart
     *
     * @return redirect
     */
    public function add(Request $request)
    {
      $product_name = $request->input('product_name');

      foreach($this->products as $key => $product) {
          if ( $product['name'] == $product_name ) {
             $product_key = $key;
          }
       }

       $existing = false;

       foreach(session('cart_products') as $key => $product) {
           if ( $product['name'] == $product_name ) {
              $updated_entry = session('cart_products');
              $updated_entry[$key]['quantity'] += 1;
              $updated_entry[$key]['total'] += $updated_entry[$key]['price'];

              session(['cart_products' => $updated_entry]);

              $existing = true;
           }
       }

       if(!$existing) {
         $new_entry = [
           "name" => $this->products[$product_key]['name'],
           "price" => $this->products[$product_key]['price'],
           "quantity" => 1,
           "total" => $this->products[$product_key]['price']
         ];

         \Session::push('cart_products', $new_entry);
       }

       return $this->redirectToProducts();
    }

    /**
     * Delete product from cart
     *
     * @return redirect
     */
    public function delete(Request $request)
    {
      $product_name = $request->input('product_name');

      foreach(session('cart_products') as $key => $product) {
          if ( $product['name'] == $product_name ) {
             $updated_entry = session('cart_products');
             $new_overall_total = session('cart_total') - ($updated_entry[$key]['price'] * $updated_entry[$key]['quantity']);
             unset($updated_entry[$key]);

             session(['cart_products' => $updated_entry]);
          }
      }

      return $this->redirectToProducts();
    }

    /**
     * Redirect to products page with updated data
     *
     * @return redirect
     */
    private function redirectToProducts()
    {
      return redirect()->route('products', ['products' => $this->products, 'cart_products' => session('cart_products'), 'overall_total' => array_sum(array_column(session('cart_products'),'total'))]);
    }
}
