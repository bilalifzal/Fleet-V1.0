<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Command | @yield('title')</title>
    
    <!-- Ultra Professional Fonts & Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        brand: {
                            'dark': '#0a0e17', // Deeper than gray-950
                            'panel': '#111827',
                            'accent': '#06b6d4', // Cyan
                            'accent-dark': '#0891b2',
                            'success': '#10b981',
                            'warning': '#f59e0b',
                            'danger': '#ef4444',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .glass-card {
            background: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        /* Sleek scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #0a0e17; }
        ::-webkit-scrollbar-thumb { background: #1f2937; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #06b6d4; }
    </style>
</head>
<body class="bg-brand-dark text-gray-100 antialiased font-sans" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- === 🚀 SUPER REALISTIC SIDEBAR === -->
        <aside class="bg-brand-panel border-r border-gray-800 w-64 space-y-6 pt-5 flex-shrink-0 transition-all duration-300 ease-in-out z-30"
               :class="sidebarOpen ? 'ml-0' : '-ml-64'">
            <div class="flex items-center justify-between px-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-brand-accent flex items-center justify-center animate-pulse">
                        <i class="fas fa-satellite-dish text-brand-dark text-lg"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-white">FLEET<span class="text-brand-accent">.</span>IO</span>
                </div>
            </div>

            <nav class="space-y-1 px-3">
                <a href="/command-center" class="group flex items-center gap-3 bg-gray-800 text-brand-accent px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-th-large"></i> Command Center
                </a>
                <a href="#" class="group flex items-center gap-3 text-gray-400 hover:bg-gray-800/50 hover:text-white px-4 py-2.5 rounded-lg text-sm transition-colors">
                    <i class="fas fa-truck-moving"></i> Live Fleet Map
                </a>
                <a href="#" class="group flex items-center gap-3 text-gray-400 hover:bg-gray-800/50 hover:text-white px-4 py-2.5 rounded-lg text-sm transition-colors">
                    <i class="fas fa-tools"></i> AI Maintenance <span class="ml-auto text-xs bg-brand-danger px-2 py-0.5 rounded-full text-white">2</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- === 🔝 TOP NAVIGATION === -->
            <header class="bg-brand-dark/80 backdrop-blur-sm border-b border-gray-800 py-3 px-6 z-20">
                <div class="flex items-center justify-between">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <div class="flex items-center gap-5">
                        <div class="relative">
                            <i class="fas fa-bell text-gray-500 hover:text-brand-warning cursor-pointer"></i>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-brand-danger rounded-full animate-ping"></span>
                        </div>
                        <div class="flex items-center gap-3 border-l border-gray-800 pl-5">
                            <img src="https://ui-avatars.com/api/?name=Bilal+Ifzal&background=06b6d4&color=fff" class="w-9 h-9 rounded-full border-2 border-brand-accent">
                            <div>
                                <div class="text-sm font-semibold text-white">M. Bilal Ifzal</div>
                                <div class="text-xs text-brand-accent font-mono">Fleet Commander</div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- === 💻 MAIN CONTENT SLOT === -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-brand-dark/50 p-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>