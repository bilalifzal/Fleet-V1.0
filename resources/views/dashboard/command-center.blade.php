<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Command | Mission Control</title>
    
    <!-- Pro-Level Assets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Poppins', 'sans-serif'],
                        display: ['Orbitron', 'sans-serif'] 
                    },
                    colors: {
                        navy: '#020617',
                        panel: '#0f172a',
                        neon: '#06b6d4'
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.05); }
        .neon-border:hover { border-color: #06b6d4; box-shadow: 0 0 15px rgba(6, 182, 212, 0.2); }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    </style>
</head>
<body class="bg-navy text-slate-200 font-sans overflow-hidden" x-data="{ sidebarOpen: true, liveFuel: 4502 }">

    <!-- Parent Container -->
    <div class="flex h-screen w-full">

        <!-- === 🛠️ THE SIDEBAR (Integrated) === -->
        <aside class="bg-panel border-r border-slate-800 transition-all duration-500 ease-in-out flex flex-col"
               :class="sidebarOpen ? 'w-72' : 'w-20'">
            
            <div class="p-6 flex items-center gap-4">
                <div class="w-10 h-10 bg-neon rounded-xl flex items-center justify-center shadow-lg shadow-neon/20">
                    <i class="fas fa-shuttle-space text-navy text-xl"></i>
                </div>
                <h1 class="font-display font-bold text-xl tracking-tighter text-white" x-show="sidebarOpen" x-transition>FLEET.IO</h1>
            </div>

            <nav class="flex-1 px-4 space-y-2 mt-4">
                <a href="#" class="flex items-center gap-4 p-3 bg-neon/10 text-neon rounded-xl border border-neon/20">
                    <i class="fas fa-chart-line w-6 text-center"></i>
                    <span x-show="sidebarOpen">Command Center</span>
                </a>
                <a href="#" class="flex items-center gap-4 p-3 text-slate-400 hover:bg-slate-800 rounded-xl transition-all">
                    <i class="fas fa-truck-fast w-6 text-center"></i>
                    <span x-show="sidebarOpen">Live Assets</span>
                </a>
                <a href="#" class="flex items-center gap-4 p-3 text-slate-400 hover:bg-slate-800 rounded-xl transition-all">
                    <i class="fas fa-shield-halved w-6 text-center"></i>
                    <span x-show="sidebarOpen">Security Logs</span>
                </a>
            </nav>

            <div class="p-4 bg-slate-900/50 m-4 rounded-2xl border border-slate-800" x-show="sidebarOpen">
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">System Load</p>
                <div class="h-1 w-full bg-slate-800 rounded-full mt-2 overflow-hidden">
                    <div class="h-full bg-neon w-[65%] animate-pulse"></div>
                </div>
            </div>
        </aside>

        <!-- === 🖥️ THE MAIN CONTENT === -->
        <div class="flex-1 flex flex-col overflow-hidden bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-slate-900 via-navy to-navy">
            
            <!-- Top Header -->
            <header class="h-20 border-b border-slate-800 flex items-center justify-between px-8 bg-navy/50 backdrop-blur-md">
                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white transform transition-transform active:scale-90">
                        <i class="fas fa-bars-staggered text-xl"></i>
                    </button>
                    <div class="h-8 w-[1px] bg-slate-800"></div>
                    <h2 class="text-sm font-semibold tracking-widest text-slate-400 uppercase">Sector 7-G <span class="text-neon ml-2">Active</span></h2>
                </div>

                <div class="flex items-center gap-6">
                    <div class="text-right hidden md:block">
                        <p class="text-xs font-bold text-white uppercase tracking-tighter">M. Bilal Ifzal</p>
                        <p class="text-[10px] text-neon font-mono">ID: CMD-99120</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Bilal+Ifzal&background=06b6d4&color=fff" class="w-10 h-10 rounded-full border-2 border-neon/50">
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 p-8 overflow-y-auto">
                
                <!-- Dashboard Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                    
                    <!-- Card 1 -->
                    <div class="glass p-6 rounded-3xl neon-border transition-all group">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 bg-blue-500/10 rounded-2xl text-blue-400 group-hover:scale-110 transition-transform">
                                <i class="fas fa-microchip"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Active Units</span>
                        </div>
                        <h3 class="text-4xl font-display font-bold text-white">128</h3>
                        <p class="text-xs text-blue-400 mt-2 font-medium">98.2% Operational</p>
                    </div>

                    <!-- Card 2 (Live Fuel) -->
                    <div class="glass p-6 rounded-3xl neon-border transition-all group" x-init="setInterval(() => liveFuel += Math.floor(Math.random() * 3), 2000)">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 bg-amber-500/10 rounded-2xl text-amber-400 group-hover:scale-110 transition-transform">
                                <i class="fas fa-fire-flame-simple"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Fuel Burn</span>
                        </div>
                        <h3 class="text-4xl font-display font-bold text-white" x-text="liveFuel.toLocaleString()">4,502</h3>
                        <p class="text-xs text-amber-400 mt-2 font-medium animate-pulse">Real-time sync...</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="glass p-6 rounded-3xl neon-border transition-all group">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 bg-emerald-500/10 rounded-2xl text-emerald-400 group-hover:scale-110 transition-transform">
                                <i class="fas fa-route"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Global Reach</span>
                        </div>
                        <h3 class="text-4xl font-display font-bold text-white">24<span class="text-lg text-slate-500">/7</span></h3>
                        <p class="text-xs text-emerald-400 mt-2 font-medium">0.02ms Latency</p>
                    </div>

                    <!-- Card 4 (Alerts) -->
                    <div class="glass p-6 rounded-3xl border-red-500/20 group hover:border-red-500 transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 bg-red-500/10 rounded-2xl text-red-400 group-hover:animate-bounce">
                                <i class="fas fa-skull-crossbones"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Critical Alerts</span>
                        </div>
                        <h3 class="text-4xl font-display font-bold text-red-500">03</h3>
                        <p class="text-xs text-red-400 mt-2 font-medium underline cursor-pointer">View Incidents</p>
                    </div>
                </div>

                <!-- Bottom Section: Map & Intel -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    
                    <!-- The Big Map View -->
                    <div class="xl:col-span-2 glass rounded-[2.5rem] p-2 relative group overflow-hidden border border-slate-800">
                        <div class="absolute top-6 left-6 z-10 bg-navy/80 p-4 rounded-2xl border border-slate-700 backdrop-blur-md">
                            <p class="text-[10px] font-bold text-neon uppercase tracking-widest mb-1">Satellite Visual</p>
                            <p class="text-xs font-mono text-white">Faisalabad, PK | 31.4187° N</p>
                        </div>
                        <img src="https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?q=80&w=2066&auto=format&fit=crop" 
                             class="w-full h-[450px] object-cover rounded-[2rem] opacity-50 grayscale group-hover:grayscale-0 transition-all duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy to-transparent"></div>
                    </div>

                    <!-- Live Feed -->
                    <div class="glass rounded-[2.5rem] p-8 flex flex-col border border-slate-800">
                        <h4 class="font-display text-sm font-bold tracking-widest mb-6 flex items-center gap-2">
                            <span class="w-2 h-2 bg-neon rounded-full animate-ping"></span>
                            INTELLIGENCE STREAM
                        </h4>
                        
                        <div class="flex-1 space-y-6 overflow-y-auto font-mono text-[11px]">
                            <div class="flex gap-4 border-l border-neon/30 pl-4 py-1">
                                <span class="text-slate-600">11:24</span>
                                <p class="text-slate-300"><span class="text-neon">[AUTH]</span> Commander Ifzal initialized session.</p>
                            </div>
                            <div class="flex gap-4 border-l border-red-500/30 pl-4 py-1">
                                <span class="text-slate-600">11:20</span>
                                <p class="text-slate-300"><span class="text-red-500">[WARN]</span> TRK-45 Speed anomaly detected (140km/h).</p>
                            </div>
                            <div class="flex gap-4 border-l border-slate-700 pl-4 py-1">
                                <span class="text-slate-600">11:15</span>
                                <p class="text-slate-300"><span class="text-slate-500">[SYS]</span> DB Handshake completed successfully.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

</body>
</html>