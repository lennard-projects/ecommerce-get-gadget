@extends('layout')

@section('content')
    <div class="flex justify-center m-6">
        <h1 class="text-lg font-semibold">Products</h1>
    </div>
    <div class="p-4 w-full">
        <div class="flex w-full">
            <div class="w-1/2">
                <form action="products">
                    <div class="relative border-2 border-gray-100 m-4 rounded-lg">
                        <div class="absolute top-4 left-3">
                            <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i>
                        </div>
                        <input type="text" name="search"
                            class="h-14 w-full pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none"
                            placeholder="Search product..." />
                        <div class="absolute top-2 right-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold p-2 rounded mx-2 w-[80px]">
                                Search
                            </button>  
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="w-1/2 flex items-center justify-end">
                <form action="{{ route('admin.deleteUnusedCarts') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 hover:bg-red-700 text-white font-semibold p-2 rounded mx-2 w-auto">Delete All Unused Carts</button>
                </form>
                <a href="{{ route('admin.createProduct') }}">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold p-2 rounded mx-2">New Product +</button>
                </a>
            </div>
        </div>
        @unless (count($products) == 0)
            <div class="max-w-7xl mx-auto">

                <table class="border-collapse w-full mt-3 text-sm">
                    <thead class="text-xs uppercase border border-gray-100">
                        <tr>
                            <th class="px-3 py-3 border">ID</th>
                            <th class="px-3 py-3 border">Image</th>
                            <th class="px-3 py-3 border">Name</th>
                            {{-- <th class="px-3 py-3 border">Description</th> --}}
                            <th class="px-3 py-3 border">Stock</th>
                            <th class="px-3 py-3 border">Price</th>
                            <th class="px-3 py-3 border w-[100px]">Actions</th>
                        </tr>
                    </thead>

                    @foreach ($products as $product)
                        <tbody class="text-center">
                            <tr>
                                <td class="px-3 py-2 border">{{ $product->id }}</td>

                                <td class="px-3 py-2 border">
                                    <div class="flex justify-center">
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="" width="30">
                                    </div>
                                </td>
                                <td class="px-3 py-2 border">
                                    <a href="{{ route('admin.showProduct', ['product' => $product->id]) }}">{{ $product->name }}</a>
                                </td>
                                {{-- <td class="px-3 py-2 border w-[200px]"><p class="line-clamp-2 ">{{ $product->description }}...</p></td> --}}
                                <td class="px-3 py-2 border">{{ $product->stock }}</td>
                                <td class="px-3 py-2 border">₱{{ $product->price }}</td>
                                <td class="px-3 py-2 border flex justify-center w-full">
                                    {{-- admin/products/{{$product->id}}/editProduct --}}
                                    <a href="{{ route('admin.editProduct', ['product' => $product->id]) }}">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold p-2 rounded mx-2 w-[80px]">Edit</button>
                                    </a>
                                    <form action="{{ route('admin.deleteProduct', ['product' => $product->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 hover:bg-red-700 text-white font-semibold p-2 rounded mx-2 w-[80px]">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        @else
            <div>
                <h1>No products found.</h1>
            </div>
        @endunless
    </div>
    <div>
        <div>
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
@endsection
