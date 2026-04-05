<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons & CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4318FF',
                        secondary: '#1B2559',
                        light: '#F4F7FE',
                        brand: {
                            50: '#E7E9FF', 100: '#C1C8FF', 200: '#909DFF', 300: '#5F72FF', 
                            400: '#2E47FF', 500: '#4318FF', 600: '#3311CC', 700: '#220B99', 800: '#110566'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F4F7FE; color: #1B2559; }
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="bg-[#F4F7FE]">

    <div id="admin-wrapper" class="w-full transition-all duration-300 relative overflow-x-hidden">
        
        @include('layouts.partials.admin-sidebar')

        <div id="main-content" class="transition-all duration-300 min-h-screen">
            @include('layouts.partials.admin-header')

            <div class="p-4 md:p-8 min-h-[calc(100vh-120px)]">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @yield('content')
            </div>
            
            <footer class="p-8 text-center text-sm text-[#A3AED0]">
                &copy; {{ date('Y') }} {{ config('app.name') }} Admin Dashboard.
            </footer>
        </div>
    </div>

    @stack('scripts')
    @yield('scripts')
</body>
</html>