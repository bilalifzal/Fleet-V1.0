<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet | Asset Radar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.05); }
        /* Radar sweep animation for the background */
        .radar-bg {
            background: radial-gradient(circle at center, rgba(6, 182, 212, 0.1) 0%, transparent 70%);
            border: 1px solid rgba(6, 182, 212, 0.1);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#020617] text-slate-200 font-['Poppins'] overflow-hidden" x-data="{ sidebarOpen: true, showDeployModal: false }">

    <div class="flex h-screen w-full">
        <!-- Sidebar Component -->
        <x-sidebar active="assets" />

        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <!-- Background Radar aesthetic -->
            <div class="absolute inset-0 z-0 pointer-events-none flex items-center justify-center opacity-20">
                <div class="w-[800px] h-[800px] rounded-full radar-bg flex items-center justify-center animate-[spin_10s_linear_infinite]">
                    <div class="w-1/2 h-full border-r-2 border-cyan-500/50"></div>
                </div>
            </div>

            <!-- Header -->
            <header class="h-20 border-b border-slate-800 flex items-center justify-between px-8 bg-[#020617]/80 backdrop-blur-md z-10">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white"><i class="fas fa-bars-staggered"></i></button>
                <h2 class="font-['Orbitron'] text-sm tracking-[0.2em] text-cyan-400">GLOBAL ASSET RADAR</h2>
                <div class="flex items-center gap-4">
                    <button @click="showDeployModal = true" class="bg-cyan-500/10 hover:bg-cyan-500 text-cyan-400 hover:text-[#020617] px-4 py-2 rounded-lg text-xs font-bold border border-cyan-500/30 transition-all">
                        + DEPLOY ASSET
                    </button>
                </div>
            </header>

            <main class="flex-1 p-8 overflow-y-auto z-10">
                
                <!-- LIVE DATABASE LOOP -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($trucks as $truck)
                    <div class="glass p-6 rounded-[2rem] border border-slate-800 transition-all group hover:scale-[1.02] {{ $truck->current_speed > 0 ? 'hover:border-emerald-500/50' : 'hover:border-amber-500/50' }}">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-900 border border-slate-700 flex items-center justify-center">
                                    <i class="fas fa-truck text-xl {{ $truck->current_speed > 0 ? 'text-emerald-400' : 'text-slate-500' }}"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-lg font-['Orbitron']">{{ $truck->unit_number ?? 'TRK-000' }}</h3>
                                    <p class="text-[10px] text-slate-500 font-mono tracking-widest">HEAVY FREIGHT</p>
                                </div>
                            </div>
                            
                            <!-- Dynamic Status Tag based on Live Speed -->
                            @if($truck->current_speed > 0)
                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-bold px-2 py-1 rounded animate-pulse">
                                    IN TRANSIT
                                </span>
                            @else
                                <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[10px] font-bold px-2 py-1 rounded">
                                    IDLE
                                </span>
                            @endif
                        </div>

                        <div class="space-y-4 bg-slate-900/50 p-4 rounded-xl border border-slate-800/50">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] uppercase tracking-widest text-slate-500">Current Velocity</span>
                                <span class="font-['Orbitron'] font-bold {{ $truck->current_speed > 0 ? 'text-cyan-400' : 'text-white' }}">{{ $truck->current_speed ?? 0 }} <span class="text-[10px] text-slate-500">KM/H</span></span>
                            </div>
                            
                            <!-- Telemetry Bar -->
                            <div>
                                <div class="h-1 w-full bg-slate-800 rounded-full overflow-hidden">
                                    @if($truck->current_speed > 0)
                                        <div class="h-full bg-cyan-400" style="width: {{ min(($truck->current_speed / 120) * 100, 100) }}%"></div>
                                    @else
                                        <div class="h-full bg-slate-600 w-full"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 opacity-50">
                        <i class="fas fa-satellite-dish text-4xl text-slate-500 mb-4 animate-pulse"></i>
                        <p class="text-sm text-slate-400 font-bold font-['Orbitron'] tracking-widest">NO ASSETS DETECTED IN SECTOR</p>
                    </div>
                    @endforelse
                </div>

            </main>

            <!-- === DEPLOY ASSET MODAL === -->
            <div x-show="showDeployModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div x-show="showDeployModal" x-transition.opacity class="absolute inset-0 bg-[#020617]/80 backdrop-blur-sm" @click="showDeployModal = false"></div>
                
                <div x-show="showDeployModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     class="glass relative z-10 w-full max-w-md p-8 rounded-[2rem] border border-cyan-500/30 shadow-[0_0_30px_rgba(6,182,212,0.15)]">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-['Orbitron'] text-xl text-white tracking-widest"><i class="fas fa-truck text-cyan-400 mr-2"></i> DEPLOY ASSET</h3>
                        <button @click="showDeployModal = false" class="text-slate-500 hover:text-red-500 transition-colors"><i class="fas fa-times text-xl"></i></button>
                    </div>

                    <form method="POST" action="/dashboard/assets/deploy" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Unit Number / Call Sign</label>
                            <input type="text" name="unit_number" placeholder="TRK-999" required class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 font-mono transition-colors">
                        </div>

                        <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-400 text-[#020617] font-bold tracking-widest uppercase py-4 rounded-xl mt-4 transition-all hover:shadow-[0_0_15px_rgba(6,182,212,0.4)]">
                            Initialize Vehicle
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>
</html>