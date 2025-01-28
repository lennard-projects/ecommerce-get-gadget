@extends('layout')

@section('content')
    <div class="flex justify-between">
        Dashboard
        <a href="/admin/createProduct">
            <button>New Product</button>
        </a>
        <a href="/admin/products">
            <button>Show products</button>
        </a>
    </div>
@endsection
