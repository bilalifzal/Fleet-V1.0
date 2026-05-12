<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet | System Config</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.05); }
        .toggle-checkbox:checked { right: 0; border-color: #06b6d4; }
        .toggle-checkbox:checked + .toggle-label { background-color: #06b6d4; }
    </style>
</head>
<body class="bg-[#020617] text-slate-200 font-['Poppins'] overflow-hidden" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen w-full">
        <!-- Sidebar Component -->
        <x-sidebar active="settings" />

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- MASTER FORM WRAPPER -->
            <form method="POST" action="/dashboard/settings/update" class="flex-1 flex flex-col h-full">
                @csrf
                
                <!-- Header -->
                <header class="h-20 border-b border-slate-800 flex items-center justify-between px-8 bg-[#020617]/50 backdrop-blur-md">
                    <button type="button" @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white"><i class="fas fa-bars-staggered"></i></button>
                    <h2 class="font-['Orbitron'] text-sm tracking-[0.2em] text-slate-400">GLOBAL PARAMETERS</h2>
                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-cyan-500 text-[#020617] px-6 py-2 rounded-lg text-xs font-bold transition-all hover:shadow-[0_0_15px_rgba(6,182,212,0.5)]">
                            SAVE CONFIG
                        </button>
                    </div>
                </header>

                <main class="flex-1 p-8 overflow-y-auto">
                    <div class="max-w-4xl mx-auto space-y-8">
                        
                        <!-- Global Fleet Constraints -->
                        <div class="glass rounded-[2rem] p-8 border border-slate-800">
                            <h3 class="font-['Orbitron'] text-lg text-white mb-6 flex items-center gap-3">
                                <i class="fas fa-sliders text-cyan-400"></i> Fleet Constraints
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Max Fleet Speed Limit (km/h)</label>
                                    <input type="number" name="max_speed_limit" value="{{ $settings->max_speed_limit }}" class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 font-mono text-lg transition-colors">
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Idle Engine Cutoff (Minutes)</label>
                                    <input type="number" name="idle_engine_cutoff" value="{{ $settings->idle_engine_cutoff }}" class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 font-mono text-lg transition-colors">
                                </div>
                            </div>
                        </div>

                        <!-- Security & Encryption -->
                        <div class="glass rounded-[2rem] p-8 border border-slate-800">
                            <h3 class="font-['Orbitron'] text-lg text-white mb-6 flex items-center gap-3">
                                <i class="fas fa-fingerprint text-emerald-400"></i> API & Encryption Keys
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2">Google Maps Geolocation API Key</label>
                                    <input type="text" name="google_maps_key" value="{{ $settings->google_maps_key }}" class="w-full bg-slate-900/50 border border-slate-700 text-cyan-400 rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 font-mono text-sm transition-colors">
                                </div>

                                <!-- Awesome CSS Toggle -->
                                <div class="flex items-center justify-between p-4 bg-slate-900/50 border border-slate-700 rounded-xl hover:border-cyan-500/50 transition-colors">
                                    <div>
                                        <h4 class="text-sm font-bold text-white">Strict CNIC Validation</h4>
                                        <p class="text-[10px] text-slate-500 mt-1">Require exact format match for all new administrative accounts.</p>
                                    </div>
                                    <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                        <!-- The checkbox uses the database boolean to determine if it should be checked -->
                                        <input type="checkbox" name="strict_cnic_validation" id="toggle1" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" {{ $settings->strict_cnic_validation ? 'checked' : '' }}/>
                                        <label for="toggle1" class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-600 cursor-pointer"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
            </form>
            <!-- END MASTER FORM -->

        </div>
    </div>
</body>
</html>