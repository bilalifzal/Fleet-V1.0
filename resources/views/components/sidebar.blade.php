@props(['active' => 'command'])
<!-- Notice the 'justify-between' added to the flex column to push logout to the bottom -->
<aside class="bg-[#0f172a] border-r border-slate-800 transition-all duration-500 ease-in-out flex flex-col h-screen sticky top-0"
       :class="sidebarOpen ? 'w-72' : 'w-20'">
    
    <div>
        <div class="p-6 flex items-center gap-4">
            <div class="w-10 h-10 bg-[#06b6d4] rounded-xl flex items-center justify-center shadow-lg shadow-cyan-500/20 shrink-0">
                <i class="fas fa-shuttle-space text-[#020617] text-xl"></i>
            </div>
            <h1 class="font-['Orbitron'] font-bold text-xl tracking-tighter text-white whitespace-nowrap overflow-hidden" x-show="sidebarOpen">FLEET.IO</h1>
        </div>

        <nav class="px-4 space-y-2 mt-4 max-h-[60vh] overflow-y-auto">
            <!-- ORIGINAL LINKS -->
            <a href="/command-center" class="flex items-center gap-4 p-3 rounded-xl transition-all {{ $active == 'command' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : 'text-slate-400 hover:bg-slate-800' }}">
                <i class="fas fa-chart-line w-6 text-center"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Command Center</span>
            </a>
            <a href="/dashboard/assets" class="flex items-center gap-4 p-3 rounded-xl transition-all {{ $active == 'assets' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : 'text-slate-400 hover:bg-slate-800' }}">
                <i class="fas fa-truck-fast w-6 text-center"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Live Assets</span>
            </a>
            <a href="/dashboard/fuel" class="flex items-center gap-4 p-3 rounded-xl transition-all {{ $active == 'fuel' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : 'text-slate-400 hover:bg-slate-800' }}">
                <i class="fas fa-gas-pump w-6 text-center"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Fuel Intelligence</span>
            </a>
            <a href="/dashboard/security" class="flex items-center gap-4 p-3 rounded-xl transition-all {{ $active == 'security' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : 'text-slate-400 hover:bg-slate-800' }}">
                <i class="fas fa-shield-halved w-6 text-center"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Security Logs</span>
            </a>

            <div class="h-px bg-slate-800 my-4" x-show="sidebarOpen"></div>

            <!-- NEW LINKS -->
            <a href="/dashboard/maintenance" class="flex items-center gap-4 p-3 rounded-xl transition-all {{ $active == 'maintenance' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : 'text-slate-400 hover:bg-slate-800' }}">
                <i class="fas fa-wrench w-6 text-center"></i><span x-show="sidebarOpen" class="whitespace-nowrap">AI Maintenance</span>
            </a>
            <a href="/dashboard/drivers" class="flex items-center gap-4 p-3 rounded-xl transition-all {{ $active == 'drivers' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : 'text-slate-400 hover:bg-slate-800' }}">
                <i class="fas fa-users-gear w-6 text-center"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Driver Roster</span>
            </a>
            <a href="/dashboard/ledger" class="flex items-center gap-4 p-3 rounded-xl transition-all {{ $active == 'ledger' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : 'text-slate-400 hover:bg-slate-800' }}">
                <i class="fas fa-file-invoice-dollar w-6 text-center"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Financial Ledger</span>
            </a>
            <a href="/dashboard/settings" class="flex items-center gap-4 p-3 rounded-xl transition-all {{ $active == 'settings' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : 'text-slate-400 hover:bg-slate-800' }}">
                <i class="fas fa-microchip w-6 text-center"></i><span x-show="sidebarOpen" class="whitespace-nowrap">System Config</span>
            </a>
        </nav>
    </div>

    <!-- LOGOUT SECTION (Pushed to bottom) -->
    <div class="p-4 mt-auto border-t border-slate-800">
        <!-- We use a form because Logout MUST be a POST request for security -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 p-3 text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-xl transition-all group">
                <i class="fas fa-power-off w-6 text-center group-hover:animate-pulse"></i>
                <span x-show="sidebarOpen" class="font-bold tracking-widest text-sm">TERMINATE SESSION</span>
            </button>
        </form>
    </div>
</aside>