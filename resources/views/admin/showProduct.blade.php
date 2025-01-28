@extends('layout')

@section('content')
    <div class="flex w-full justify-center p-10 h-[100vh]">
        <div class="flex justify-between p-10 bg-gray-100 rounded-md w-full">
           <div class="flex items-center justify-center w-1/2">
            <p>{{ $product->id }}</p>
            <p>{{ $product->name }}</p>
            <p>{{ $product->description }}</p>
            <p>{{ $product->price }}</p>
            <p>{{ $product->stock }}</p>
           </div>
            
            <div class="flex items-center justify-center w-1/2">
                <div class="p-4">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="image">
                </div>
                
            </div>
        </div>
        
    </div>
@endsection