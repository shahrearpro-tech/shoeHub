<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>@yield('title', config('app.name', 'ShoeHub'))</title>
    <meta name="description" content="@yield('description', 'Premium export quality and branded shoes')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Preconnect for Faster External Assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400&display=swap" rel="stylesheet">
    
    <!-- Custom CSS (Versioned for Caching) -->
    @php $assetVersion = '1.0.5'; @endphp
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ $assetVersion }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}?v={{ $assetVersion }}">
    
    <!-- Custom CSS Variables -->
    <style>
        :root {
            --primary: {{ $settings['theme_color_primary'] ?? '#4318FF' }};
            --secondary: {{ $settings['theme_color_secondary'] ?? '#1B2559' }};
            --accent: {{ $settings['theme_color_accent'] ?? '#FF5B5B' }};
        }
    </style>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $settings['theme_color_primary'] ?? '#4318FF' }}', 
                        secondary: '{{ $settings['theme_color_secondary'] ?? '#1B2559' }}',
                        accent: '{{ $settings['theme_color_accent'] ?? '#FF5B5B' }}',
                        light: '#F4F7FE',
                        dark: '#0B1437',
                        success: '#05CD99',
                        info: '#33A1FD',
                        warning: '#FFB547',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        display: ['Outfit', 'sans-serif'],
                        playfair: ['"Playfair Display"', 'serif'],
                    },
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="font-sans bg-light">
    
    <!-- DEBUG: LAYOUT_APP_V2 -->
    @include('layouts.partials.header')

    <main id="main-content-v2" class="min-h-screen pt-0 pb-20 lg:pb-0">
        @if(session('success'))
            <div class="container mx-auto px-4 py-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="container mx-auto px-4 py-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @include('layouts.partials.mobile-bottom-nav')

    @include('layouts.partials.chat-widget')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const BASE_URL = '{{ url("/") }}';
        const CSRF_TOKEN = '{{ csrf_token() }}';
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        });
    </script>
    <script src="{{ asset('assets/js/main.js') }}?v={{ $assetVersion }}"></script>
    @stack('scripts')
</body>
</html>