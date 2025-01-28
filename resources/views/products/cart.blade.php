@extends('layout')

@section('content')
    <div class="flex flex-col justify-center">
        <section class="h-100">
            <div class="container py-5">
                <div class="row d-flex justify-content-center my-4">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0" id="cart-count">Cart - {{ count($cart) <= 1 ? count($cart) . ' item' : count($cart) . ' items' }}</h5>
                            </div>
                            @unless (count($cart) == 0)
                            @foreach ($cart as $item)
                                <div class="card-body" id="cart-item_{{ $item->product_id }}">
                                    <div class="row">
                                        <div
                                            class="col-lg-3 col-md-6 mb-4 mb-lg-0 d-flex justify-content-center bg-gray-100">
                                            <div class="w-50 p-2">
                                                <img src="{{ asset('storage/' . $item->image_path) }}" class="" alt="" />
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                            <p><strong>{{ $item->name }}</strong></p>
                                            <p>Stock: {{ $item->stock }}</p>
                                            <button type="button" class="btn btn-primary btn-sm mt-2" title="Remove item"
                                                onclick="removeItem({{ $item->id }}, {{ $item->product_id }}, {{ count($cart) }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                            <div class="d-flex mb-4" style="max-width: 300px">
                                                <div>
                                                    <button class="btn btn-primary mx-1" onclick="decrement({{ $item->product_id }}, {{ $item->id }}, {{ $item->price }})" id="decrementButton_{{ $item->product_id }}" class="bg-blue-500 {{ $item->quantity <= 1 ? ' bg-gray-500' : '' }}" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                                <div class="d-flex justify-content-center text-center">
                                                    <div class="form-outline">
                                                        <input class="text-center form-control" type="number" id="quantity_{{ $item->product_id }}" value={{ $item->quantity }} min="1" readonly disabled />
                                                        <label class="form-label">Quantity</label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button class="btn btn-primary mx-1"
                                                        onclick="increment({{ $item->product_id }}, {{ $item->id }}, {{ $item->price }})"
                                                        id="incrementButton_{{ $item->product_id }}"
                                                        {{ $item->quantity >= $item->stock ? 'disabled' : '' }}>
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-center text-md-center">
                                                ₱ <span id="price_{{ $item->product_id }}">{{ number_format($item->price * $item->quantity) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                </div>
                            @endforeach
                            @else
                            <div class="p-10 text-center text-md">
                                <h1>No item in cart.</h1>
                            </div>
                            @endunless
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0">Summary</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                        Products 
                                        <p>₱<span id="productsTotal">{{ number_format($productsTotal) }}</span></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        Shipping
                                        <p>₱<span>0.00</span></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                        <div>
                                            <strong>Total Amount</strong>
                                        </div>
                                        <p>₱<span id="grandTotal">{{ number_format($grandTotal) }}</span></p>
                                    </li>
                                </ul>
                                <button class="btn btn-primary btn-lg btn-block" onclick="checkout({{ Auth::user()->id ?? null }})">
                                    Proceed to Pay
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- 
            <div class="inline-block {{ $item->stock <= 0 ? 'bg-black-500' : 'bg-gray-100' }}">
                <h1>{{ $item->name }}</h1>
                <input type="number" id="price_{{ $item->product_id }}" value={{ $item->price * $item->quantity }} readonly>
                <div>
                    <button onclick="decrement({{ $item->product_id }}, {{ $item->id }}, {{ $item->price }})" id="decrementButton_{{ $item->product_id }}" class="bg-blue-500 {{ $item->quantity <= 1 ? ' bg-gray-500' : '' }}" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                    <input type="number" id="quantity_{{ $item->product_id }}" value={{ $item->quantity }} min="1" readonly>
                    <button onclick="increment({{ $item->product_id }}, {{ $item->id }}, {{ $item->price }})" id="incrementButton_{{ $item->product_id }}" {{ $item->quantity >= $item->stock ? 'disabled' : '' }}>+</button>
                    <button onclick="removeItem({{ $item->id }})">Remove Item</button>
                    <p>Stock: {{ $item->stock }}</p>
                </div>
            </div>
         --}}
        {{-- <div>
            <div>
                <p>Total: ₱ <span id="grandTotal">{{ $grandTotal }}</span></p>
                <button onclick="checkout({{ Auth::user()->id ?? null }})">Checkout</button>
            </div>
        </div> --}}
    </div>

    <script>
        function increment(productId, cartItemId, cartItemPrice) {

            // console.log('haha');
            let currentQuantity = $('#quantity_' + productId).val();

            let newQuantity = parseInt(currentQuantity) + 1;

            let currentPrice = $('#price_' + productId).val();

            // let newPrice = parseInt(currentPrice) * newQuantity;
            let newPrice = cartItemPrice * newQuantity;
            // console.log(newPrice);

            // console.log(currentQuantity);
            // console.log(newQuantity);
            // console.log(cartItemId);
            $('#incrementButton_' + productId).prop("disabled", true);
            $.ajax({
                url: '{{ route('cart.increment') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: 1,
                    cart_item_id: cartItemId,
                    cart_item_price: cartItemPrice
                },
                success: function(response) {
                    console.log(response.quantity + " " + response.stock);

                    if (response.quantity && response.price) {
                        $('#quantity_' + productId).val(newQuantity)
                        //     alert(response.message);
                        // // Optionally, update the cart total or other UI elements here
                        // $('#cart-total').text('Total: $' + response.total);
                        let formatSingleTotal = new Intl.NumberFormat('en-US').format(newPrice);
                        $('#price_' + productId).text(formatSingleTotal)
                        let formatGrandTotal = new Intl.NumberFormat('en-US').format(response.grandTotal);
                        $('#grandTotal').text(formatGrandTotal);
                        
                        
                        let formatProductsTotal = new Intl.NumberFormat('en-US').format(response.productsTotal);
                        // console.log(formattedPrice);
                        $('#productsTotal').text(formatProductsTotal);
                        if (response.quantity > 1) {
                            $('#decrementButton_' + productId).attr("disabled", false);
                        } 
                        if (response.quantity >= response.stock) {
                            $('#incrementButton_' + productId).attr("disabled", true);
                        } else {
                            setTimeout(() => {
                                $('#incrementButton_' + productId).prop("disabled", false);
                            }, 100)
                        }
                    } else {
                        console.log(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('There was an error while updating the cart.');
                }
            });
        }

        function decrement(productId, cartItemId, cartItemPrice) {
            let currentQuantity = $('#quantity_' + productId).val();
            // if(currentQuantity <= 1) {
                // $('#decrementButton_' + productId).attr("disabled", true);
            //     // setTimeout(function() {
            //     //     button.prop('disabled', false);
            //     // }, 1000);
            // }
            // $('#decrementButton_' + productId).attr("disabled", true);
            $('#decrementButton_' + productId).prop("disabled", true);
            // $('#decrementButton_' + productId).attr("disabled", true);
            let newQuantity = parseInt(currentQuantity) - 1;

            // let currentPrice = $('#price_' + productId).val();

            let newPrice = cartItemPrice * newQuantity;

            $.ajax({
                url: '{{ route('cart.decrement') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: 1,
                    product_id: productId,
                    cart_item_price: cartItemPrice,
                    cart_item_id: cartItemId
                },
                success: function(response) {
                    console.log(response.quantity + " " + response.stock);

                    if (response.success === 'success') {
                        $('#quantity_' + productId).val(response.quantity);
                        // $('#price_' + productId).val(response.price);
                        // $('#grandTotal').text(response.grandTotal);
                        // $('#productsTotal').text(response.productsTotal);
                        let formatSingleTotal = new Intl.NumberFormat('en-US').format(newPrice);
                        $('#price_' + productId).text(formatSingleTotal)
                        let formatGrandTotal = new Intl.NumberFormat('en-US').format(response.grandTotal);
                        $('#grandTotal').text(formatGrandTotal);
                        
                        
                        let formatProductsTotal = new Intl.NumberFormat('en-US').format(response.productsTotal);
                        // setTimeout(() => {
                            // $('#decrementButton_' + productId).prop("disabled", false);
                        // }, 500);
                        
                        // console.log(formattedPrice);
                        $('#productsTotal').text(formatProductsTotal);
                        if (response.quantity <= 1) {
                            $('#decrementButton_' + productId).attr("disabled", true);
                        } else {
                            setTimeout(() => {
                                $('#decrementButton_' + productId).prop("disabled", false);
                            }, 500);
                        }

                        if (response.quantity < response.stock) {
                            $('#incrementButton_' + productId).attr("disabled", false);
                        }
                    }

                },
                error: function(xhr, status, error) {
                    console.log(error);

                }
            });
        }

        function removeItem(cartItemId, productId,cartCount) {
            // console.log(cartItemId);
            $.ajax({
                url: '{{ route('cart.removeItem' )}}',
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    cart_item_id: cartItemId
                },
                success: function (response) {
                    console.log(response);
                    if(response.success) {
                        $('#cart-item_' + productId).attr('style', 'display: none')
                        $('#cart-count').text(response.count <= 1 ? 'Cart - ' + response.count + ' item' : 'Cart - ' + response.count + ' items')
                    }
                }, 
                error: function (xhr, status, error) {
                    console.log(error);
                    
                }
            })

        }

        function checkout(user) {
            console.log(user);


        }
    </script>
    {{-- // $.ajax({
        //     url: '{{ route('user.checkout') }}',
        //     method: 'POST',
        //     data: {
        //         _token: '{{ csrf_token() }}',
        //         user: user
        //     },
        //     success: function(response) {
        //         console.log(response);
                
        //     },
        //     error: function (xhr, status, error) {
        //         console.log(error);
                
        //     }
        // }); 
        
        $.ajax({
                url: '{{ route('cart.removeItem') }}',
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                    cart_item_id: cartItemId
                },
                success: function (response) {
                    console.log(response);
                }, 
                error: function (xhr, status, error) {
                    console.log(error);
                    
                }
            })
        
        
        
        
        --}}
@endsection
