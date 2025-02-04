<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Get.Gadget</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="css/style.css" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('/images/logo-1.png') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>
    <nav class="p-2">
        <div class="flex items-center justify-between">
            @if (Auth::guard('admin')->check())
                <div class="flex items-center">
                    <a href="/admin/dashboard"><img class="w-24" src="{{ asset('images/logo-1.png') }}" alt=""
                            class="logo" /></a>
                </div>
                <div class="flex items-center justify-start font-semibold text-md">
                    <div class="m-2">
                        <a href="/admin/dashboard">
                            <h1>DASHBOARD</h1>
                        </a>
                    </div>
                    <div class="m-2">
                        <a href="/admin/products">
                            <h1>PRODUCTS</h1>
                        </a>
                    </div>
                    <div class="m-2">
                        <a href="/admin/transactions">
                            <h1>TRANSACTIONS</h1>
                        </a>
                    </div>
                    <div class="m-2">
                        <a href="/admin/users">
                            <h1>USERS</h1>
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <p class="mr-4">Hello, {{ Auth::guard('admin')->user()->name }}</p>
                    <a href="{{ route('admin.logout') }}">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mr-8">
                            Logout
                        </button>
                    </a>
                </div>
            @elseif (Auth::user() || !Auth::user())
                @if (!Route::is('admin.login'))
                    <div class="flex items-center">
                        <a href="/user/home"><img class="w-24" src="{{ asset('images/logo-1.png') }}" alt=""
                                class="logo" /></a>
                    </div>

                    <div class="flex">
                        <div class="flex items-center justify-start font-semibold text-md mr-4">
                            <div class="m-2">
                                <a href="/user/cart">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                            </div>
                        </div>
                        @if (Auth::user())
                            <x-menu />
                        @else
                            @if (!Route::is('user.login'))
                                <a href="login">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mr-8">
                                        Login
                                    </button>
                                </a>
                            @endif

                        @endif
                    </div>
                @endif
            @endif
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
    <div id="alertMessage"
        class="alert z-10 fixed top-1/2 left-1/2 transform -translate-x-1/2 text-black-300 px-48 py-3 font-semibold"
        style="display: none;"></div>
</body>
<script>
    function toggleMenu() {
        $('#menu').toggle();
    }
</script>

</html>
