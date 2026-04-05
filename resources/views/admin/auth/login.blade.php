<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ShoeHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-10 border border-gray-100">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black text-gray-900 mb-2">Admin Portal</h1>
            <p class="text-gray-400 font-semibold px-4">Secure access for authorized personnel only</p>
        </div>
        
        <form action="{{ route('admin.login.process') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Important: we use the same login route but the Middleware will handle redirection after login based on role -->
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email Address</label>
                <input type="email" name="email" required class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-900 focus:ring-2 focus:ring-blue-600 outline-none transition" placeholder="admin@shoehub.com">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-900 focus:ring-2 focus:ring-blue-600 outline-none transition" placeholder="••••••••">
            </div>
            
            <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold uppercase tracking-wider hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                Authenticate
            </button>
        </form>
    </div>
</body>
</html>