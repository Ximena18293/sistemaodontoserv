<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Odontoserv')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex">
      
        <aside class="w-64 bg-yellow-400 text-black min-h-screen shadow-lg border-r-8 border-black">
            <div class="p-4 flex justify-center">
                <img src="{{ asset('logo.jpeg') }}" alt="Odontoserv Logo" class="w-48 h-auto border border-black border-2 p-2">
            </div>

            <nav class="mt-10">
                <ul>
                    <hr class="border-t-2 border-orange-800 mx-3">
                    <li class="mb-4">
                        <!-- Redirigir al Dashboard -->
                        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 hover:bg-black hover:text-white rounded transition duration-300">
                            <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                            <span class="text-sm font-medium">Menu</span>
                        </a>
                    </li>
                    
                    <hr class="border-t-2 border-orange-800 mx-3">
                    <li class="mb-4">
                        <a href="{{route('products.index')}}" class="flex items-center px-6 py-3 hover:bg-black hover:text-white rounded transition duration-300">
                            <i class="fas fa-box w-5 h-5 mr-3"></i>
                            <span class="text-sm font-medium">Productos</span>
                        </a>
                    </li>
                    <hr class="border-t-2 border-orange-800 mx-3">
                    <li class="mb-4">
                        <a href="{{route('users.index')}}" class="flex items-center px-6 py-3 hover:bg-black hover:text-white rounded transition duration-300">
                            <i class="fas fa-users w-5 h-5 mr-3"></i>
                            <span class="text-sm font-medium">Usuarios</span>
                        </a>
                    </li>
                    <hr class="border-t-2 border-orange-800 mx-3">
                    <li class="mb-4">
                        <a href="#" class="flex items-center px-6 py-3 hover:bg-black hover:text-white rounded transition duration-300">
                            <i class="fas fa-users w-5 h-5 mr-3"></i>
                            <span class="text-sm font-medium">Clientes</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Contenido Principal -->
        <div class="flex-1">
            <!-- Encabezado -->
            <header class="bg-white shadow-lg p-4 flex justify-between items-center border-b-4 border-yellow-400">
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('header', 'Menú')</h1>
                </div>
                <div class="relative">
                    <button id="userMenuButton" class="flex items-center space-x-2 text-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        <span>Hola, {{ Auth::user()->name }}</span>
                        <i class="fas fa-caret-down w-4 h-4"></i>
                    </button>
                    <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-20 hidden">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configuraciones</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-sm hover:bg-gray-200 w-full text-left text-black">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="p-8 bg-gray-50 min-h-screen">
               
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    @livewireScripts
    @stack('scripts')
    <script>
        // Toggle user menu
        document.getElementById('userMenuButton').addEventListener('click', function () {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
