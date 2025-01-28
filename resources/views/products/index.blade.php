@extends('layout')

@section('content')
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 lg:max-w-7xl lg:px-8 py-6">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-error">{{ Session::get('error') }}</div>
            @endif
            <h2 class="sr-only">Products</h2>
            
            <div class="grid grid-cols-1 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8 w-full">
                @unless (count($products) == 0)
                    @foreach ($products as $product)
                        <div class="my-8 w-full rounded-xl bg-gray-50 shadow-md">
                            <div class="flex justify-center items-center pt-4">
                                <a href="#" class="group justify-items-center">
                                    {{ $product->stock === 0 ? 'Out of Stock' : '' }}
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="product"
                                        class="aspect-square w-[150px] rounded-lg bg-gray-200 object-full group-hover:opacity-75 xl:aspect-[7/8]">
                                    <h3 class="mt-4 text-sm text-gray-700 line-clamp-1 font-semibold mx-2">{{ $product->name }}
                                    </h3>
                                    <p class="mt-1 text-lg font-medium text-gray-700 mx-2">₱{{ number_format($product->price) }}
                                    </p>
                                    <p class="mt-1 text-lg font-medium text-gray-700 mx-2">Stock: {{ $product->stock }}</p>
                                </a>
                            </div>

                            {{-- <div class="flex items-end h-auto">
                                    <form action="{{ route('cart.addToCart') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-2 rounded mr-8 w-full mt-2">
                                            Add to Cart
                                        </button>
                                    </form>
                                    
                                </div> --}}
                            <div class="flex justify-center h-auto">
                                {{-- {{ $product->stock === 0 ? 'bg-gray-500' : 'bg-blue-500'}}" disabled --}}
                                <button onclick="addToCart({{ $product->id }}, {{ Cookie::get('cartCookie') }}, {{ $product->price }})"
                                    class="hover:bg-blue-700 text-white font-semibold py-1 px-2 rounded w-full mt-2 {{ $product->stock === 0 ? 'bg-gray-500' : 'bg-blue-500' }}">
                                    Add to Cart
                                </button>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div>
                        <h1>No products found.</h1>
                    </div>
                @endunless

            </div>
            <div class="flex flex-row justify-center inline-block">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <script>
        function addToCart(productId, sessionId, productPrice) {
            $.ajax({
                url: '{{ route('cart.addToCart') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    session_id: sessionId,
                    product_price: productPrice
                },
                success: function(response) {
                    if (response.success) {
                        $('#alertMessage').text(response.success); // Display message
                        $('#alertMessage').removeClass('alert-error').addClass('alert-success'); // Style as success
                        $('#alertMessage').show(); // Show the alert message

                        // Optionally, hide the alert after 3 seconds
                        setTimeout(function() {
                            $('#alertMessage').fadeOut();
                        }, 1500);
                    }

                    if(response.exist) {
                        $('#alertMessage').text(response.exist); // Display message
                        $('#alertMessage').removeClass('alert-error').addClass('alert-success'); // Style as success
                        $('#alertMessage').show(); // Show the alert message

                        // Optionally, hide the alert after 3 seconds
                        setTimeout(function() {
                            $('#alertMessage').fadeOut();
                        }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('there was an error.')
                }
            })
        }
    </script>

@endsection
