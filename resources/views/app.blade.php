<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/js/app.js', 'resources/css/app.css'])
    </head>
    <body class="bg-gray-200">
        <div id="app">
            <nav class="bg-white shadow">
                <div class="container flex items-center justify-center p-6 mx-auto text-gray-600 capitalize">
                    <router-link to="/users" active-class="border-b-2 border-blue-500" class="text-gray-800 transition-colors duration-300 transform mx-1.5 sm:mx-6">
                        Users
                    </router-link>

                    <router-link to="/accounts" active-class="border-b-2 border-blue-500" class="text-gray-800 transition-colors duration-300 transform mx-1.5 sm:mx-6">
                        Accounts
                    </router-link>

                    <router-link to="/new-transaction" active-class="border-b-2 border-blue-500" class="text-gray-800 transition-colors duration-300 transform mx-1.5 sm:mx-6">
                        New transaction
                    </router-link>
                </div>
            </nav>

            <main class="flex flex-col items-center py-4">
                    <router-view></router-view>
            </main>
        </div>
    </body>
</html>
