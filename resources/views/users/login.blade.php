@extends('layout')

@section('content')
    <div class="flex justify-center w-full">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 primary p-4 w-3/6 rounded-md shadow-md">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm ">
                <img class="mx-auto h-[51px] w-[101px]" src="{{ asset('images/logo-1.png') }}" alt="logo">
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
            </div>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm primary">
                <form class="space-y-6" action="{{ route('user.authenticate') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="text-sm/6 font-medium text-gray-900">Email address</label>
                        <div class="mt-2">
                            <input type="text" name="email" id="email" autocomplete="email"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>

                            <div class="text-sm">
                                <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot
                                    password?</a>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input type="password" name="password" id="password" autocomplete="current-password" required
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign
                            in</button>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm/6 text-gray-500">
                    Don't have an account yet?
                    <a href="/user/create" class="font-semibold text-indigo-600 hover:text-indigo-500">Register</a>
                </p>
            </div>
        </div>
    </div>
@endsection
