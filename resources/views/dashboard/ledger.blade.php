<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet | Financial Ledger</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=JetBrains+Mono:wght@400;700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    <style>
        .glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.05); }
        .hash-text { font-family: 'JetBrains Mono', monospace; }
        /* Hide Alpine elements until loaded */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#020617] text-slate-200 font-['Poppins'] overflow-hidden" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen w-full">
        <!-- Sidebar Component -->
        <x-sidebar active="ledger" />

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-20 border-b border-slate-800 flex items-center justify-between px-8 bg-[#020617]/50 backdrop-blur-md">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white"><i class="fas fa-bars-staggered"></i></button>
                <h2 class="font-['Orbitron'] text-sm tracking-[0.2em] text-emerald-400">IMMUTABLE LEDGER</h2>
                <div class="flex items-center gap-4">
                    <i class="fas fa-link text-emerald-500 animate-pulse"></i>
                    <span class="text-xs font-mono text-emerald-500">LIVE BLOCK SYNC: ACTIVE</span>
                </div>
            </header>

            <main class="flex-1 p-8 overflow-y-auto">
                
                <!-- Top Stats (LIVE MATH) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="glass p-6 rounded-2xl border-l-4 border-l-emerald-500 transition-all hover:scale-[1.02]">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Gross Revenue</p>
                        <h3 class="font-['Orbitron'] text-3xl font-bold text-white">${{ number_format($revenue, 2) }}</h3>
                        <p class="text-xs text-emerald-400 mt-2 flex items-center gap-2">
                            <i class="fas fa-arrow-up"></i> Live Tracking Active
                        </p>
                    </div>
                    
                    <div class="glass p-6 rounded-2xl border-l-4 border-l-red-500 transition-all hover:scale-[1.02]">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Total Expenses</p>
                        <h3 class="font-['Orbitron'] text-3xl font-bold text-white">${{ number_format($expense, 2) }}</h3>
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-2">
                            <i class="fas fa-arrow-down"></i> Live Tracking Active
                        </p>
                    </div>
                    
                    <div class="glass p-6 rounded-2xl border-l-4 border-l-cyan-500 transition-all hover:scale-[1.02]">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Net Margin</p>
                        <h3 class="font-['Orbitron'] text-3xl font-bold text-cyan-400">{{ number_format($margin, 1) }}%</h3>
                        <p class="text-xs text-slate-500 mt-2 flex items-center gap-2">
                            <i class="fas fa-chart-pie"></i> Highly Optimized
                        </p>
                    </div>
                </div>

                <!-- Transaction Blockchain (LIVE LOOP) -->
                <div class="glass rounded-[2.5rem] p-8 border border-slate-800">
                    <h4 class="font-['Orbitron'] text-sm font-bold text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-cubes text-cyan-400"></i> Recent Encrypted Transactions
                    </h4>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-800 text-[10px] text-slate-500 uppercase tracking-widest">
                                    <th class="pb-3 px-4">Tx Hash (SHA-256)</th>
                                    <th class="pb-3 px-4">Date / Time</th>
                                    <th class="pb-3 px-4">Unit</th>
                                    <th class="pb-3 px-4">Description</th>
                                    <th class="pb-3 px-4 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs hash-text text-slate-300">
                                @forelse($transactions as $tx)
                                <tr class="border-b border-slate-800/50 hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 px-4 text-cyan-500">{{ $tx->tx_hash }}</td>
                                    <td class="py-4 px-4 text-slate-500 font-sans">{{ $tx->created_at->format('M d, Y - H:i') }}</td>
                                    <td class="py-4 px-4 text-white font-sans">{{ $tx->truck_unit }}</td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 py-1 rounded font-sans font-bold tracking-widest {{ $tx->type == 'REVENUE' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                            {{ $tx->description }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-right font-bold text-sm {{ $tx->type == 'REVENUE' ? 'text-emerald-400' : 'text-red-400' }}">
                                        {{ $tx->type == 'REVENUE' ? '+' : '-' }}${{ number_format($tx->amount, 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-500 font-sans">
                                        No transactions recorded in the ledger yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>