<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Command | Ultra-Secure Gateway</title>
    <!-- We use Tailwind CSS for that beautiful, classic aesthetic -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass-panel {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-950 text-gray-200 h-screen flex items-center justify-center bg-[url('https://images.unsplash.com/photo-1586864387789-628af9feed72?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center">
    
    <!-- Dark overlay for readability -->
    <div class="absolute inset-0 bg-gray-950/80"></div>

    <div class="relative z-10 w-full max-w-md glass-panel p-10 rounded-2xl shadow-2xl transition-all duration-500 hover:shadow-cyan-500/20">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold tracking-wider text-white uppercase">Command Center</h1>
            <p class="text-sm text-cyan-400 mt-2 font-mono tracking-widest">AUTHORIZED PERSONNEL ONLY</p>
        </div>

        <form id="secureGatewayForm" method="POST" action="/gateway/auth" class="space-y-6">
            <!-- Laravel's security token (Mandatory) -->
            @csrf 

            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">Email Identity</label>
                <input type="email" name="email" required 
                    class="w-full bg-gray-900/50 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-colors">
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">Master Password</label>
                <input type="password" name="password" required 
                    class="w-full bg-gray-900/50 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-colors">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">CNIC Number</label>
                    <input type="text" name="cnic" placeholder="XXXXX-XXXXXXX-X" required 
                        class="w-full bg-gray-900/50 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-cyan-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">Security PIN</label>
                    <input type="password" name="pin_code" maxlength="4" required 
                        class="w-full text-center tracking-[1em] bg-gray-900/50 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-cyan-500 transition-colors">
                </div>
            </div>

            <!-- Error display -->
            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-3 rounded text-sm text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="button" onclick="document.getElementById('secureGatewayForm').submit()" 
                class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold tracking-widest uppercase py-4 rounded-lg transition-all duration-300 transform hover:scale-[1.02]">
                Initialize Link
            </button>
        </form>
    </div>

    <!-- Keyboard Navigation Script -->
    <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById('secureGatewayForm').submit();
            }
        });
    </script>
</body>
</html>