<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet | AI Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.05); }
        .grid-bg {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(6, 182, 212, 0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(6, 182, 212, 0.05) 1px, transparent 1px);
        }
        .scanner {
            width: 100%; height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(6, 182, 212, 0.2), transparent);
            animation: scan 3s ease-in-out infinite alternate;
        }
        @keyframes scan { 0% { transform: translateY(-100%); } 100% { transform: translateY(100%); } }
        /* Hide Alpine elements until loaded */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#020617] text-slate-200 font-['Poppins'] overflow-hidden" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen w-full">
        <!-- Sidebar Component -->
        <x-sidebar active="maintenance" />

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-20 border-b border-slate-800 flex items-center justify-between px-8 bg-[#020617]/50 backdrop-blur-md z-20 relative">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white"><i class="fas fa-bars-staggered"></i></button>
                <h2 class="font-['Orbitron'] text-sm tracking-[0.2em] text-cyan-400">AI DIAGNOSTIC MATRIX</h2>
                <div class="flex items-center gap-4">
                    <span class="text-[10px] font-bold bg-cyan-500/10 text-cyan-400 px-3 py-1 rounded-full border border-cyan-500/20 animate-pulse">PREDICTIVE ENGINE ONLINE</span>
                </div>
            </header>

            <main class="flex-1 p-8 overflow-y-auto grid-bg relative">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative z-10 h-full">
                    
                    <!-- 3D Holographic Scanner Simulation -->
                    <div class="lg:col-span-2 glass rounded-[2.5rem] p-8 border border-slate-800 relative overflow-hidden flex flex-col items-center justify-center min-h-[500px]">
                        <!-- Scanning Animation overlay -->
                        <div class="absolute inset-0 scanner z-0"></div>
                        
                        <div class="text-center relative z-10">
                            <i class="fas fa-truck-monster text-9xl text-cyan-500/20 mb-8"></i>
                            <h3 class="font-['Orbitron'] text-2xl text-white tracking-widest mb-2">FLEET WIREFRAME</h3>
                            <p class="text-sm text-cyan-400 font-mono">Running deep structural scan across all nodes...</p>
                            
                            <!-- Diagnostic Points -->
                            <div class="absolute top-10 left-10 text-left">
                                <div class="w-3 h-3 bg-red-500 rounded-full animate-ping mb-2"></div>
                                <p class="text-[10px] text-red-400 font-bold tracking-widest">CRITICAL SYSTEMS MONITORED</p>
                            </div>
                            <div class="absolute bottom-20 right-10 text-right">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full mb-2 ml-auto shadow-[0_0_10px_#10b981]"></div>
                                <p class="text-[10px] text-emerald-400 font-bold tracking-widest">SENSORS CALIBRATED</p>
                            </div>
                        </div>
                    </div>

                    <!-- AI Predictive Queue (LIVE DATABASE LOOP) -->
                    <div class="glass rounded-[2.5rem] p-8 border border-slate-800 flex flex-col h-full max-h-[700px]">
                        <h4 class="font-['Orbitron'] text-sm font-bold text-white mb-6 flex items-center gap-2">
                            <i class="fas fa-microchip text-cyan-400"></i> Repair Forecast
                        </h4>
                        
                        <div class="space-y-4 flex-1 overflow-y-auto pr-2 custom-scrollbar">
                            
                            @if($alerts->count() > 0)
                                @foreach($alerts as $alert)
                                <!-- Dynamic styling based on AI Severity -->
                                <div class="p-4 bg-slate-900/50 border rounded-2xl transition-all hover:scale-[1.02] {{ $alert->severity == 'URGENT' ? 'border-red-500/30 hover:border-red-500' : 'border-amber-500/30 hover:border-amber-500' }}">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-bold {{ $alert->severity == 'URGENT' ? 'text-red-400' : 'text-amber-400' }}">{{ $alert->truck->unit_number }}</span>
                                        <span class="text-[10px] px-2 py-1 font-bold rounded tracking-widest {{ $alert->severity == 'URGENT' ? 'bg-red-500/20 text-red-400' : 'bg-amber-500/20 text-amber-400' }}">
                                            {{ $alert->severity }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-300">
                                        {{ $alert->component }} failure predicted in <span class="text-white font-bold">{{ $alert->days_to_failure }} days</span>.
                                    </p>
                                    <div class="mt-4">
                                        <div class="flex justify-between text-[10px] font-mono text-slate-500 mb-1">
                                            <span>Wear & Tear</span>
                                            <span class="font-bold {{ $alert->wear_percentage > 80 ? 'text-red-400' : 'text-amber-400' }}">{{ $alert->wear_percentage }}%</span>
                                        </div>
                                        <div class="h-1.5 w-full bg-slate-800 rounded-full overflow-hidden">
                                            <div class="h-full {{ $alert->severity == 'URGENT' ? 'bg-red-500' : 'bg-amber-500' }}" style="width: {{ $alert->wear_percentage }}%"></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <!-- Empty State if Fleet is 100% Healthy -->
                                <div class="flex flex-col items-center justify-center h-full text-center opacity-50">
                                    <i class="fas fa-shield-check text-4xl text-emerald-500 mb-4"></i>
                                    <p class="text-sm text-emerald-400 font-bold">All Systems Nominal</p>
                                    <p class="text-[10px] text-slate-500 mt-2">No predictive failures detected.</p>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>
</html>