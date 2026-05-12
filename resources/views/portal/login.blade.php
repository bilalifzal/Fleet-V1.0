<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Driver Portal | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Mobile-app style input fields */
        input { font-size: 16px; } /* Prevents iOS auto-zoom */
    </style>
</head>
<body class="bg-black text-white font-['Poppins'] min-h-screen flex items-center justify-center">

    <!-- MOBILE DEVICE WRAPPER -->
    <!-- This max-w-md forces the UI to look like a phone even on a desktop screen! -->
    <div class="w-full max-w-md h-screen sm:h-[850px] sm:rounded-[3rem] bg-[#020617] border-0 sm:border-[8px] border-slate-900 overflow-hidden relative flex flex-col shadow-2xl">
        
        <!-- Top Status Bar (Fake Mobile Notch area) -->
        <div class="h-10 w-full flex justify-between items-center px-6 text-xs text-slate-500 font-bold tracking-widest mt-2">
            <span>SECURE LINK</span>
            <div class="flex gap-2">
                <i class="fas fa-signal"></i>
                <i class="fas fa-wifi"></i>
                <i class="fas fa-battery-full text-emerald-500"></i>
            </div>
        </div>

        <main class="flex-1 flex flex-col items-center justify-center p-8 text-center">
            
            <div class="w-24 h-24 bg-cyan-500/10 rounded-full flex items-center justify-center border border-cyan-500/30 mb-8 shadow-[0_0_30px_rgba(6,182,212,0.2)]">
                <i class="fas fa-steering-wheel text-4xl text-cyan-400"></i>
            </div>

            <h1 class="font-['Orbitron'] text-3xl font-bold tracking-widest text-white mb-2">DRIVER PORTAL</h1>
            <p class="text-sm text-slate-400 mb-10">Scan badge or enter Employee ID</p>

            @if(session('error'))
                <div class="bg-red-500/20 border border-red-500/50 text-red-400 p-4 rounded-xl text-xs font-bold tracking-widest w-full mb-6 animate-pulse">
                    <i class="fas fa-triangle-exclamation mr-2"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/portal/authenticate" class="w-full space-y-6">
                @csrf
                
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-id-card text-slate-500"></i>
                    </div>
                    <input type="text" name="employee_id" placeholder="e.g. DRV-001" required autocomplete="off" class="w-full bg-slate-900 border-2 border-slate-800 text-center text-white rounded-2xl py-4 focus:outline-none focus:border-cyan-500 font-mono text-xl tracking-[0.2em] uppercase transition-colors placeholder-slate-700">
                </div>

                <button type="submit" class="w-full bg-cyan-500 text-black font-bold tracking-widest uppercase py-4 rounded-2xl transition-all active:scale-95 shadow-[0_0_20px_rgba(6,182,212,0.4)]">
                    CLOCK IN / INITIATE
                </button>
            </form>

        </main>

        <footer class="p-6 text-center text-[10px] text-slate-600 uppercase tracking-widest">
            Fleet Command System v2.0<br>Authorized Personnel Only
        </footer>

    </div>

</body>
</html>