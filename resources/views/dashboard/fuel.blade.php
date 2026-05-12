<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet | Fuel Intelligence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.05); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#020617] text-slate-200 font-['Poppins'] overflow-hidden" x-data="{ sidebarOpen: true, showFuelModal: false }">

    <div class="flex h-screen w-full">
        <x-sidebar active="fuel" />

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-20 border-b border-slate-800 flex items-center justify-between px-8 bg-[#020617]/50 backdrop-blur-md">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white"><i class="fas fa-bars-staggered"></i></button>
                <h2 class="font-['Orbitron'] text-sm tracking-[0.2em] text-cyan-400">FUEL INTELLIGENCE</h2>
                <div class="flex items-center gap-4">
                    <button @click="showFuelModal = true" class="bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-[#020617] px-4 py-2 rounded-lg text-xs font-bold border border-amber-500/30 transition-all">
                        <i class="fas fa-gas-pump mr-2"></i> LOG REFUEL
                    </button>
                </div>
            </header>

            <main class="flex-1 p-8 overflow-y-auto">
                <div class="glass rounded-[2.5rem] p-8 border border-slate-800">
                    <h4 class="font-['Orbitron'] text-sm font-bold text-white mb-6">Encrypted Fuel Telemetry</h4>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-800 text-[10px] text-slate-500 uppercase tracking-widest">
                                    <th class="pb-3 px-4">Date/Time</th>
                                    <th class="pb-3 px-4">Asset Unit</th>
                                    <th class="pb-3 px-4">Location</th>
                                    <th class="pb-3 px-4">Volume (Liters)</th>
                                    <th class="pb-3 px-4">Cost</th>
                                    <th class="pb-3 px-4 text-right">Security AI</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-slate-300">
                                @forelse($fuelLogs as $log)
                                <tr class="border-b border-slate-800/50 hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 px-4 text-xs font-mono text-slate-500">{{ $log->created_at->format('M d - H:i') }}</td>
                                    <td class="py-4 px-4 font-bold text-white">{{ $log->truck->unit_number ?? 'UNKNOWN' }}</td>
                                    <td class="py-4 px-4 text-cyan-400 font-mono text-xs">{{ $log->location }}</td>
                                    <td class="py-4 px-4 font-mono">{{ $log->liters }} L</td>
                                    <td class="py-4 px-4 text-red-400 font-bold">${{ number_format($log->cost, 2) }}</td>
                                    <td class="py-4 px-4 text-right">
                                        @if($log->security_status == 'Verified')
                                            <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-bold px-2 py-1 rounded">VERIFIED</span>
                                        @else
                                            <span class="bg-red-500/10 text-red-400 border border-red-500/20 text-[10px] font-bold px-2 py-1 rounded animate-pulse">ANOMALOUS</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center py-10 text-slate-500 font-bold">NO FUEL DATA DETECTED</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

            <!-- REFUEL MODAL -->
            <div x-show="showFuelModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div x-show="showFuelModal" x-transition.opacity class="absolute inset-0 bg-[#020617]/80 backdrop-blur-sm" @click="showFuelModal = false"></div>
                
                <div x-show="showFuelModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="glass relative z-10 w-full max-w-md p-8 rounded-[2rem] border border-amber-500/30 shadow-[0_0_30px_rgba(245,158,11,0.15)]">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-['Orbitron'] text-xl text-white tracking-widest"><i class="fas fa-gas-pump text-amber-400 mr-2"></i> LOG REFUEL</h3>
                        <button @click="showFuelModal = false" class="text-slate-500 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
                    </div>

                    <form method="POST" action="/dashboard/fuel/log" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Select Asset (Truck)</label>
                            <select name="truck_id" required class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-amber-500">
                                @foreach($trucks as $truck)
                                    <option value="{{ $truck->id }}">{{ $truck->unit_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Liters Pumped</label>
                                <input type="number" step="0.1" name="liters" placeholder="150.5" required class="w-full bg-slate-900/50 border border-slate-700 text-white font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-amber-500">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Total Cost ($)</label>
                                <input type="number" step="0.01" name="cost" placeholder="450.00" required class="w-full bg-slate-900/50 border border-slate-700 text-white font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-amber-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">GPS Location / Station</label>
                            <input type="text" name="location" placeholder="SHELL - HIGHWAY 66" required class="w-full bg-slate-900/50 border border-slate-700 text-cyan-400 font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-amber-500">
                        </div>

                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-[#020617] font-bold tracking-widest uppercase py-4 rounded-xl mt-4 transition-all">
                            Submit Telemetry
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>
</html>