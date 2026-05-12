<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet | Security Command</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=JetBrains+Mono:wght@400;700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    <style>
        .glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.05); }
        .terminal-text { font-family: 'JetBrains Mono', monospace; }
        .radar {
            background: repeating-radial-gradient(
                rgba(16, 185, 129, 0.1) 0,
                rgba(16, 185, 129, 0.1) 10px,
                transparent 10px,
                transparent 20px
            );
        }
        .scan-line {
            width: 100%;
            height: 2px;
            background: #10b981;
            box-shadow: 0 0 10px #10b981;
            animation: scan-vertical 4s linear infinite;
        }
        @keyframes scan-vertical { 0% { transform: translateY(0); } 100% { transform: translateY(300px); } }
    </style>
</head>
<body class="bg-[#020617] text-slate-200 font-['Poppins'] overflow-hidden" x-data="{ sidebarOpen: true, activeKeys: 1024 }">

    <div class="flex h-screen w-full">
        <!-- The Component keeps our design perfectly aligned -->
        <x-sidebar active="security" />

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-20 border-b border-slate-800 flex items-center justify-between px-8 bg-[#020617]/50 backdrop-blur-md">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white"><i class="fas fa-bars-staggered"></i></button>
                    <h2 class="font-['Orbitron'] text-sm tracking-[0.2em] text-emerald-500">DEFENSE MAINFRAME</h2>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs font-mono text-emerald-500 animate-pulse">FIREWALL ACTIVE</span>
                    <i class="fas fa-shield-check text-emerald-500 text-xl"></i>
                </div>
            </header>

            <main class="flex-1 p-8 overflow-y-auto">
                
                <!-- Security Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="glass p-6 rounded-2xl border-emerald-500/20" x-init="setInterval(() => activeKeys = Math.floor(Math.random() * (1200 - 1000) + 1000), 1000)">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Rolling Encryption Keys</p>
                        <h3 class="font-['Orbitron'] text-3xl font-bold text-emerald-400" x-text="activeKeys">1024</h3>
                        <p class="text-[10px] text-emerald-500/70 mt-1">AES-256 Bit Rotation Active</p>
                    </div>
                    
                    <div class="glass p-6 rounded-2xl border-slate-800">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Blocked Threats</p>
                        <h3 class="font-['Orbitron'] text-3xl font-bold text-slate-300">42,091</h3>
                        <p class="text-[10px] text-slate-500 mt-1">Last 24 Hours</p>
                    </div>

                    <div class="glass p-6 rounded-2xl border-slate-800">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Network Status</p>
                        <h3 class="font-['Orbitron'] text-3xl font-bold text-cyan-400 flex items-center gap-2">
                            <span class="w-3 h-3 bg-cyan-400 rounded-full animate-ping"></span> SECURE
                        </h3>
                    </div>
                </div>

                <!-- Live Terminal & Radar -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- The Live Hacker Terminal -->
                    <div class="lg:col-span-2 glass rounded-2xl p-0 border border-slate-800 overflow-hidden flex flex-col h-[400px]">
                        <div class="bg-slate-900 px-4 py-2 border-b border-slate-800 flex gap-2 items-center">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                            <span class="ml-4 text-[10px] text-slate-500 terminal-text">root@fleet-mainframe:~</span>
                        </div>
                        <div class="p-6 flex-1 overflow-y-auto terminal-text text-xs text-emerald-400 space-y-2 relative"
                             x-data="{ logs: ['Initializing firewall...', 'Checking node integrity...', 'All sectors clear.'] }"
                             x-init="setInterval(() => { 
                                 const msgs = ['[AUTH] User login verified via CNIC bypass.', '[NET] Ping received from TRK-09.', '[SEC] Port 443 scan blocked from IP: 192.168.x.x', '[SYS] Memory garbage collection complete.'];
                                 logs.push(msgs[Math.floor(Math.random() * msgs.length)]);
                                 if(logs.length > 15) logs.shift();
                             }, 2500)">
                             
                            <!-- Render Live Logs -->
                            <template x-for="log in logs">
                                <div><span class="text-slate-500">></span> <span x-text="log"></span></div>
                            </template>
                            <div class="animate-pulse"><span class="text-slate-500">></span> _</div>
                        </div>
                    </div>

                    <!-- Cyber Radar -->
                    <div class="glass rounded-2xl border border-slate-800 relative overflow-hidden h-[400px] flex items-center justify-center radar">
                        <div class="scan-line absolute top-0"></div>
                        <div class="w-48 h-48 border border-emerald-500/30 rounded-full relative flex items-center justify-center">
                            <div class="w-32 h-32 border border-emerald-500/20 rounded-full"></div>
                            <div class="w-16 h-16 border border-emerald-500/10 rounded-full"></div>
                            <div class="absolute w-full h-[1px] bg-emerald-500/20"></div>
                            <div class="absolute h-full w-[1px] bg-emerald-500/20"></div>
                            
                            <!-- Threat Nodes -->
                            <div class="absolute top-10 left-12 w-2 h-2 bg-emerald-500 rounded-full shadow-[0_0_8px_#10b981] animate-pulse"></div>
                            <div class="absolute bottom-16 right-10 w-2 h-2 bg-emerald-500 rounded-full shadow-[0_0_8px_#10b981]"></div>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>
</body>
</html>