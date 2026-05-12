<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet | Driver Roster</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js is crucial here for the popup modal to work smoothly -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.05); }
        /* This prevents the modal from flashing on the screen when you first load the page */
        [x-cloak] { display: none !important; } 
    </style>
</head>

<!-- We added showRecruitModal: false to keep the popup hidden until you click the button -->
<body class="bg-[#020617] text-slate-200 font-['Poppins'] overflow-hidden" x-data="{ sidebarOpen: true, showRecruitModal: false }">

    <div class="flex h-screen w-full">
        <!-- Sidebar Component -->
        <x-sidebar active="drivers" />

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-20 border-b border-slate-800 flex items-center justify-between px-8 bg-[#020617]/50 backdrop-blur-md">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white"><i class="fas fa-bars-staggered"></i></button>
                <h2 class="font-['Orbitron'] text-sm tracking-[0.2em] text-cyan-400">PERSONNEL DATABASE</h2>
                <div class="flex items-center gap-4">
                    <!-- The button that triggers the Alpine.js modal -->
                    <button @click="showRecruitModal = true" class="bg-cyan-500/10 hover:bg-cyan-500 text-cyan-400 hover:text-[#020617] px-4 py-2 rounded-lg text-xs font-bold border border-cyan-500/30 transition-all">
                        + RECRUIT DRIVER
                    </button>
                </div>
            </header>

            <main class="flex-1 p-8 overflow-y-auto relative">
                
                <!-- === LIVE DATABASE DRIVER CARDS === -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($drivers as $driver)
                    <div class="glass p-6 rounded-[2rem] border border-slate-800 transition-all group {{ $driver->status == 'DRIVING' ? 'hover:border-cyan-500/50' : 'hover:border-amber-500/50' }}">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <!-- Dynamic Avatar based on their real name -->
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($driver->name) }}&background=0f172a&color={{ $driver->status == 'DRIVING' ? '06b6d4' : 'fbbf24' }}" class="w-16 h-16 rounded-2xl border border-slate-700">
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 border-2 border-[#020617] rounded-full {{ $driver->status == 'DRIVING' ? 'bg-emerald-500' : 'bg-amber-500 animate-pulse' }}"></div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-lg">{{ $driver->name }}</h3>
                                    <p class="text-[10px] {{ $driver->status == 'DRIVING' ? 'text-cyan-400' : 'text-amber-400' }} font-mono">ID: {{ $driver->employee_id }} | {{ $driver->license_class }}</p>
                                </div>
                            </div>
                            <span class="{{ $driver->status == 'DRIVING' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-amber-500/10 text-amber-400' }} text-[10px] font-bold px-2 py-1 rounded">
                                {{ $driver->status }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-[10px] font-bold text-slate-500 mb-1">
                                    <span>Fatigue Level</span>
                                    <span class="{{ $driver->fatigue_level > 80 ? 'text-amber-400' : 'text-white' }}">{{ $driver->fatigue_level }}%</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full {{ $driver->fatigue_level > 80 ? 'bg-amber-500' : 'bg-cyan-400' }}" style="width: {{ $driver->fatigue_level }}%"></div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center p-3 bg-slate-900/50 rounded-xl border border-slate-800">
                                <div class="text-[10px] text-slate-400 uppercase tracking-widest">Safety Score</div>
                                <div class="font-['Orbitron'] {{ $driver->safety_score >= 90 ? 'text-emerald-400' : 'text-white' }} font-bold">{{ $driver->safety_score }}/100</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- === THE SUPER CLASSIC RECRUIT MODAL === -->
                <div x-show="showRecruitModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                    
                    <!-- Dark blur overlay -->
                    <div x-show="showRecruitModal" x-transition.opacity class="absolute inset-0 bg-[#020617]/80 backdrop-blur-sm" @click="showRecruitModal = false"></div>
                    
                    <!-- The Glass Form -->
                    <div x-show="showRecruitModal" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-90 translate-y-10"
                         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 transform scale-90 translate-y-10"
                         class="glass relative z-10 w-full max-w-lg p-8 rounded-[2rem] border border-cyan-500/30 shadow-[0_0_30px_rgba(6,182,212,0.15)]">
                        
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-['Orbitron'] text-xl text-white tracking-widest"><i class="fas fa-user-plus text-cyan-400 mr-2"></i> NEW RECRUIT</h3>
                            <button @click="showRecruitModal = false" class="text-slate-500 hover:text-red-500 transition-colors"><i class="fas fa-times text-xl"></i></button>
                        </div>

                        <!-- Backend Connection: Submits to the route we created -->
                        <form method="POST" action="/dashboard/drivers/recruit" class="space-y-5">
                            @csrf <!-- Mandatory Security Token -->
                            
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Full Legal Name</label>
                                <input type="text" name="name" required class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 transition-colors">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Driver ID</label>
                                    <input type="text" name="employee_id" placeholder="DRV-999" required class="w-full bg-slate-900/50 border border-slate-700 text-white font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">License Class</label>
                                    <select name="license_class" required class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 transition-colors appearance-none">
                                        <option value="Class-A">Class-A (Heavy)</option>
                                        <option value="Class-B">Class-B (Standard)</option>
                                        <option value="Hazmat">Hazmat Certified</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-400 text-[#020617] font-bold tracking-widest uppercase py-4 rounded-xl mt-4 transition-all hover:shadow-[0_0_15px_rgba(6,182,212,0.4)]">
                                Initialize Personnel
                            </button>
                        </form>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>