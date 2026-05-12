<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Driver Portal | Active Mission</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style> [x-cloak] { display: none !important; } </style>
</head>
<!-- Alpine.js state for our Popups -->
<body class="bg-black text-white font-['Poppins'] min-h-screen flex items-center justify-center" x-data="{ showFuelModal: false, showMapModal: false }">

    <div class="w-full max-w-md h-screen sm:h-[850px] sm:rounded-[3rem] bg-[#020617] border-0 sm:border-[8px] border-slate-900 overflow-y-auto relative flex flex-col shadow-2xl">
        
        <div class="h-10 w-full flex justify-between items-center px-6 text-xs text-slate-500 font-bold tracking-widest mt-2 bg-[#020617] z-20 sticky top-0">
            <span class="text-emerald-500 animate-pulse">ENCRYPTED LINK</span>
            <div class="flex gap-2">
                <i class="fas fa-location-arrow"></i>
                <i class="fas fa-battery-full"></i>
            </div>
        </div>

        <main class="flex-1 flex flex-col p-6">
            
            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500">Active Operator</p>
                    <h2 class="font-['Orbitron'] text-xl font-bold text-white">{{ session('driver_name') }}</h2>
                    <p class="text-xs text-cyan-400 font-mono">{{ session('employee_id') }}</p>
                </div>
                <button @click="showMapModal = true" class="w-12 h-12 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-cyan-400 hover:bg-slate-700 transition">
                    <i class="fas fa-map-marked-alt"></i>
                </button>
            </div>

            <!-- ALERTS -->
            @if(session('success'))
                <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 p-3 rounded-xl text-[10px] font-bold tracking-widest text-center mb-4"><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-500/20 border border-red-500/50 text-red-400 p-3 rounded-xl text-[10px] font-bold tracking-widest text-center mb-4"><i class="fas fa-triangle-exclamation mr-2"></i> {{ session('error') }}</div>
            @endif

            <!-- ASSET ASSIGNMENT -->
            <div class="bg-slate-900/80 border border-slate-700 rounded-[2rem] p-6 mb-6 shadow-lg">
                <h3 class="font-['Orbitron'] text-sm text-white mb-4"><i class="fas fa-truck text-cyan-400 mr-2"></i> VEHICLE ASSIGNMENT</h3>
                
                @if(session()->has('active_truck_id'))
                    <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl p-4 text-center mb-4">
                        <span class="text-[10px] text-emerald-500 uppercase tracking-widest font-bold block mb-1">STATUS: IN TRANSIT</span>
                        <span class="font-mono text-xl text-white block">ASSET LOCKED</span>
                    </div>
                @else
                    <form method="POST" action="/portal/mission/lock" class="space-y-4">
                        @csrf
                        <select name="truck_id" required class="w-full bg-[#020617] border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none font-mono">
                            <option value="">-- PENDING ASSIGNMENT --</option>
                            @foreach($availableTrucks as $truck) <option value="{{ $truck->id }}">{{ $truck->unit_number }}</option> @endforeach
                        </select>
                        <button type="submit" class="w-full bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 font-bold tracking-widest uppercase py-3 rounded-xl">LOCK ASSET</button>
                    </form>
                @endif
            </div>

            <!-- QUICK ACTIONS -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <button @click="showFuelModal = true" class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-4 flex flex-col items-center justify-center gap-3 transition hover:bg-amber-500/20">
                    <div class="w-10 h-10 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center text-lg"><i class="fas fa-gas-pump"></i></div>
                    <span class="text-xs font-bold tracking-widest text-amber-400">LOG FUEL</span>
                </button>

                <form method="POST" action="/portal/mission/sos" class="h-full">
                    @csrf
                    <button type="submit" class="w-full h-full bg-red-500/10 border border-red-500/30 rounded-2xl p-4 flex flex-col items-center justify-center gap-3 hover:bg-red-500/20">
                        <div class="w-10 h-10 rounded-full bg-red-500/20 text-red-400 flex items-center justify-center text-lg animate-pulse"><i class="fas fa-triangle-exclamation"></i></div>
                        <span class="text-xs font-bold tracking-widest text-red-400">SOS ALERT</span>
                    </button>
                </form>
            </div>

            <!-- FUEL HISTORY LOG -->
            @if(session()->has('active_truck_id'))
            <div class="bg-slate-900/50 border border-slate-800 rounded-2xl p-5 mb-6">
                <h3 class="font-['Orbitron'] text-xs text-slate-400 mb-4 tracking-widest">RECENT FUEL TELEMETRY</h3>
                <div class="space-y-3">
                    @forelse($fuelLogs as $log)
                        <div class="flex justify-between items-center border-b border-slate-800 pb-2">
                            <div>
                                <p class="text-cyan-400 font-mono text-[10px]">{{ $log->location }}</p>
                                <p class="text-white text-xs font-bold">{{ $log->liters }} L <span class="text-slate-500 text-[10px]">(${{ $log->cost }})</span></p>
                            </div>
                            <span class="text-[8px] text-slate-500">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-center text-xs text-slate-600 font-mono italic">NO FUEL DATA DETECTED</p>
                    @endforelse
                </div>
            </div>
            @endif

        </main>
    </div>

    <!-- ========================================== -->
    <!-- ALIPNE.JS MODALS (POP-UPS) BELOW -->
    <!-- ========================================== -->

    <!-- GPS MAP MODAL -->
    <div x-show="showMapModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-[#020617]/90 backdrop-blur-md" @click="showMapModal = false"></div>
        <div x-show="showMapModal" x-transition class="relative z-10 w-full max-w-md bg-slate-900 border border-cyan-500/30 rounded-3xl overflow-hidden shadow-[0_0_30px_rgba(6,182,212,0.2)]">
            <div class="bg-[#020617] p-4 flex justify-between items-center border-b border-slate-800">
                <h3 class="font-['Orbitron'] text-sm text-cyan-400"><i class="fas fa-satellite text-cyan-500 mr-2"></i> SECURE GPS UPLINK</h3>
                <button @click="showMapModal = false" class="text-slate-500 hover:text-white"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="h-80 w-full bg-black relative">
                <!-- Cool Dark Mode Map Hack using OpenStreetMap -->
                <iframe width="100%" height="100%" frameborder="0" scrolling="no" src="https://www.openstreetmap.org/export/embed.html?bbox=-122.41,37.77,-122.39,37.80&amp;layer=mapnik&amp;marker=37.78,-122.40" style="filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(100%);"></iframe>
            </div>
        </div>
    </div>

    <!-- LOG FUEL MODAL -->
    <div x-show="showFuelModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-[#020617]/90 backdrop-blur-md" @click="showFuelModal = false"></div>
        <div x-show="showFuelModal" x-transition class="relative z-10 w-full max-w-md bg-slate-900 border border-amber-500/30 rounded-3xl p-6 shadow-[0_0_30px_rgba(245,158,11,0.2)]">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-['Orbitron'] text-sm text-amber-400"><i class="fas fa-gas-pump mr-2"></i> LOG FUEL</h3>
                <button @click="showFuelModal = false" class="text-slate-500 hover:text-white"><i class="fas fa-times text-xl"></i></button>
            </div>

            @if(session()->has('active_truck_id'))
                <form method="POST" action="/portal/mission/fuel" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Liters</label>
                            <input type="number" step="0.1" name="liters" required class="w-full bg-[#020617] border border-slate-700 text-white rounded-xl px-4 py-3 font-mono">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Cost ($)</label>
                            <input type="number" step="0.01" name="cost" required class="w-full bg-[#020617] border border-slate-700 text-white rounded-xl px-4 py-3 font-mono">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Location</label>
                        <input type="text" name="location" required class="w-full bg-[#020617] border border-slate-700 text-cyan-400 rounded-xl px-4 py-3 font-mono uppercase">
                    </div>
                    <button type="submit" class="w-full bg-amber-500 text-black font-bold tracking-widest uppercase py-4 rounded-xl mt-2 hover:bg-amber-400 transition">SUBMIT DATA</button>
                </form>
            @else
                <p class="text-red-400 text-xs text-center font-bold font-mono tracking-widest p-6 bg-red-500/10 rounded-xl border border-red-500/30">ERROR: YOU MUST LOCK A VEHICLE BEFORE LOGGING FUEL.</p>
            @endif
        </div>
    </div>

</body>
</html>