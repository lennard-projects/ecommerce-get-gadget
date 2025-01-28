@if (session()->has('message'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
        class="bg-red-500 fixed top-1/2 left-1/2 transform -translate-x-1/2 text-white px-48 py-3">
        {{ session('message') }}
    </div>
@endif
