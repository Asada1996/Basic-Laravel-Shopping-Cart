@extends('layouts.app')

@section('content')
<h2>Products</h2>

@if (count($products))
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($products as $product)
          <tr>
            <td>{{ $product['name'] }}</td>
            <td>£{{ number_format((float)$product['price'], 2, '.', '') }}</td>
            <td>
              <form action="" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="product_name" value="{{ $product['name'] }}">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-plus"></i> Add To Cart
                </button>
              </form>
            </td>
          </tr>
      @endforeach
    </tbody>
  </table>
@else
  <p>There are no products to display.</p>
@endif

<h2>Shopping Cart</h2>

@if (count($cart_products))
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($cart_products as $product)
          <tr>
            <td>{{ $product['name'] }}</td>
            <td>£{{ number_format((float)$product['price'], 2, '.', '') }}</td>
            <td>{{ $product['quantity'] }}</td>
            <td>£{{ number_format((float)$product['total'], 2, '.', '') }}</td>
            <td>
              <form action="" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="hidden" name="product_name" value="{{ $product['name'] }}">
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Remove From Cart
                </button>
              </form>
            </td>
          </tr>
      @endforeach
      <tr>
        <th>Overall Total</th>
        <td colspan="4">£{{ number_format((float)$overall_total, 2, '.', '') }}</td>
      </tr>
    </tbody>
  </table>
@else
  <p>There are no products in your cart.</p>
@endif

@endsection
