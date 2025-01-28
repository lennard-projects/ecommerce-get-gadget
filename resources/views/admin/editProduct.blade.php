@extends('layout')

@section('content')
    <div class="mx-2 my-4">
        <a href="{{ route('admin.products') }}">
            <i class="fa-solid fa-arrow-left fa-xl"></i>
        </a>
    </div>
    <div class="flex justify-center w-full">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 primary p-4 w-3/6 rounded-md shadow-md">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm ">
                <img class="mx-auto h-10 w-auto" src="{{ asset('/images/logosss.jpg') }}" alt="logo">
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Edit Product</h2>
            </div>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm primary">
                <form class="space-y-6" action="{{ route('admin.updateProduct', ['product' => $product['id']]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name" class="text-sm/6 font-medium text-gray-900">Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" autocomplete="name"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                value="{{ $product->name }}">
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="description" class="text-sm/6 font-medium text-gray-900">Description</label>
                        <div class="mt-2">
                            <textarea name="description" id="description" autocomplete="description" rows="10"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">{{ $product->description }} </textarea>
                            @error('description')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="stock" class="text-sm/6 font-medium text-gray-900">Stock</label>
                        <div class="mt-2">
                            <input type="text" name="stock" id="stock" autocomplete="stock"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                value="{{ $product->stock }}">
                            @error('stock')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="price" class="text-sm/6 font-medium text-gray-900">Price</label>
                        <div class="mt-2">
                            <input type="text" name="price" id="price" autocomplete="price"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                value="{{ $product->price }}">
                            @error('price')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="product_image" class="text-sm/6 font-medium text-gray-900">Product Image</label>
                        <div class="mt-2">
                            <input type="file" name="product_image" id="product_image" autocomplete="product_image"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                            @error('product_image')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-semibold p-2 rounded w-full">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
