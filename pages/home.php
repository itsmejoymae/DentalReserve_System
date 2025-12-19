<?php include('../includes/header.php'); ?>

<div class="sticky top-0 z-50 flex justify-center pt-6 px-4">
    <nav class="bg-white/80 backdrop-blur-lg shadow-sm border border-slate-100 rounded-[2.5rem] px-8 py-4 flex items-center w-full max-w-6xl justify-between">
        <div class="flex items-center gap-4">
            <div class="relative w-12 h-12 group cursor-pointer">
                <img src='images/Web_logo.jpeg' class="w-full h-full rounded-2xl object-cover shadow-inner border border-slate-100 group-hover:rotate-3 transition-transform">
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-400 border-2 border-white rounded-full"></div>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-black text-slate-800 tracking-tighter leading-none uppercase">Dr. B</span>
                <span class="text-[9px] font-black text-sky-500 uppercase tracking-[0.3em] mt-1">Dental Excellence</span>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <button id="openSign" onclick="modal.showModal()"
                class="btn bg-slate-900 hover:bg-sky-600 text-white border-none rounded-2xl px-10 font-black transition-all hover:scale-105 active:scale-95 normal-case h-12 shadow-lg shadow-slate-200">
                Get Started
            </button>
        </div>
    </nav>
</div>

<section class="text-center mt-28 px-6 max-w-5xl mx-auto">
    <div class="inline-flex items-center gap-3 bg-sky-50 text-sky-600 px-5 py-2.5 rounded-full mb-8 border border-sky-100/50">
        <span class="relative flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-sky-500"></span>
        </span>
        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Always Open for Emergencies</span>
    </div>
    
    <h1 class="text-6xl md:text-8xl font-black text-slate-800 tracking-tight leading-[1] mb-8">
        Your Smile, Our <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-600 italic">Priority</span>
    </h1>
    
    <p class="text-slate-500 text-lg md:text-xl max-w-2xl mx-auto font-medium leading-relaxed">
        Experience painless dentistry with world-class facilities and a team of compassionate specialists dedicated to your oral health.
    </p>
</section>

<section class="max-w-6xl mx-auto mt-40 px-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-4">
        <div class="max-w-md">
            <h2 class="text-4xl font-black text-slate-800 tracking-tight">Expert Services</h2>
            <p class="text-slate-400 font-bold text-xs uppercase tracking-[0.2em] mt-3">Comprehensive care for every age</p>
        </div>
        <div class="h-[1px] flex-1 bg-slate-100 mb-4 mx-12 hidden md:block"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="group bg-white p-10 rounded-[3rem] border border-slate-50 shadow-sm hover:shadow-2xl hover:shadow-sky-100 transition-all duration-500 hover:-translate-y-2">
            <div class="w-16 h-16 bg-emerald-50 rounded-[1.5rem] flex items-center justify-center text-3xl mb-8 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-500">🩺</div>
            <h3 class="font-black text-2xl text-slate-800 mb-4">General Checkup</h3>
            <p class="text-slate-500 leading-relaxed font-medium">Routine examinations and digital X-rays to ensure your dental health is on the right track.</p>
        </div>

        <div class="group bg-white p-10 rounded-[3rem] border border-slate-50 shadow-sm hover:shadow-2xl hover:shadow-sky-100 transition-all duration-500 hover:-translate-y-2">
            <div class="w-16 h-16 bg-sky-50 rounded-[1.5rem] flex items-center justify-center text-3xl mb-8 group-hover:bg-sky-500 group-hover:text-white transition-colors duration-500">✨</div>
            <h3 class="font-black text-2xl text-slate-800 mb-4">Teeth Cleaning</h3>
            <p class="text-slate-500 leading-relaxed font-medium">Advanced deep cleaning and polishing to remove plaque and brighten your natural smile.</p>
        </div>

        <div class="group bg-white p-10 rounded-[3rem] border border-slate-50 shadow-sm hover:shadow-2xl hover:shadow-sky-100 transition-all duration-500 hover:-translate-y-2">
            <div class="w-16 h-16 bg-rose-50 rounded-[1.5rem] flex items-center justify-center text-3xl mb-8 group-hover:bg-rose-500 group-hover:text-white transition-colors duration-500">🦷</div>
            <h3 class="font-black text-2xl text-slate-800 mb-4">Tooth Extraction</h3>
            <p class="text-slate-500 leading-relaxed font-medium">Safe, painless, and minimally invasive removal procedures for damaged or wisdom teeth.</p>
        </div>

        <div class="group bg-white p-10 rounded-[3rem] border border-slate-50 shadow-sm hover:shadow-2xl hover:shadow-sky-100 transition-all duration-500 hover:-translate-y-2">
            <div class="w-16 h-16 bg-amber-50 rounded-[1.5rem] flex items-center justify-center text-3xl mb-8 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-500">⚡</div>
            <h3 class="font-black text-2xl text-slate-800 mb-4">Root Canal</h3>
            <p class="text-slate-500 leading-relaxed font-medium">Saving your natural teeth with precision endodontic therapy and modern anesthesia.</p>
        </div>

        <div class="group bg-white p-10 rounded-[3rem] border border-slate-50 shadow-sm hover:shadow-2xl hover:shadow-sky-100 transition-all duration-500 hover:-translate-y-2 lg:col-span-2">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-16 h-16 bg-indigo-50 rounded-[1.5rem] flex items-center justify-center text-3xl shrink-0 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-500">📏</div>
                <div>
                    <h3 class="font-black text-2xl text-slate-800 mb-4">Orthodontics</h3>
                    <p class="text-slate-500 leading-relaxed font-medium">Achieve the perfect alignment with our range of traditional braces and modern clear aligner solutions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<dialog id="modal" class="modal modal-bottom sm:modal-middle backdrop-blur-md">
    <div class="modal-box bg-white p-0 rounded-[3rem] w-full max-w-md shadow-[0_30px_60px_-15px_rgba(0,0,0,0.3)] overflow-hidden border border-white">
        
        <div class="bg-gradient-to-br from-sky-600 to-blue-700 p-10 text-white relative">
            <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-inner">🔐</div>
            <h3 id="modalTitle" class="font-black text-3xl tracking-tight leading-none">Welcome Back</h3>
            <p class="text-sky-100 text-sm font-medium opacity-80 mt-2">Sign in to manage your appointments</p>
            <button class="btn btn-sm btn-circle btn-ghost absolute right-8 top-10 text-white hover:bg-white/10" onclick="modal.close()">✕</button>
        </div>

        <div class="p-10">
            <div id="loginPanel" class="space-y-6">
                <form id="signinForm" class="space-y-5">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-3">Email Address</label>
                        <input type="text" placeholder="name@email.com" id="login_email" class="input bg-slate-50 border-none w-full h-16 rounded-[1.25rem] focus:ring-4 ring-sky-100 transition-all font-bold text-slate-700 px-6" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-3">Password</label>
                        <input type="password" id="login_password" placeholder="••••••••" class="input bg-slate-50 border-none w-full h-16 rounded-[1.25rem] focus:ring-4 ring-sky-100 transition-all font-bold text-slate-700 px-6" />
                    </div>

                    <div class="pt-6 space-y-5">
                        <button type="submit" class="btn bg-sky-600 hover:bg-sky-700 border-none text-white w-full h-16 rounded-2xl font-black text-lg shadow-xl shadow-sky-100 transition-all hover:scale-[1.02] active:scale-95">
                            Log In
                        </button>
                        <div class="text-center">
                            <p class="text-sm font-bold text-slate-500">
                                New to Dr. B Clinic? 
                                <button type="button" class="text-sky-600 underline underline-offset-4 ml-1" onclick="swapForm('signup')">Create Account</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            <div id="signupPanel" class="hidden space-y-6">
                <form id="signupForm" class="space-y-5">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-3">Email Address</label>
                        <input type="text" placeholder="your@email.com" id="email" class="input bg-slate-50 border-none w-full h-16 rounded-[1.25rem] focus:ring-4 ring-sky-100 transition-all font-bold text-slate-700 px-6" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-3">New Password</label>
                        <input type="password" placeholder="Create a strong password" id="password" class="input bg-slate-50 border-none w-full h-16 rounded-[1.25rem] focus:ring-4 ring-sky-100 transition-all font-bold text-slate-700 px-6" />
                    </div>

                    <div class="pt-6 space-y-5">
                        <button type="submit" class="btn bg-emerald-500 hover:bg-emerald-600 border-none text-white w-full h-16 rounded-2xl font-black text-lg shadow-xl shadow-emerald-100 transition-all hover:scale-[1.02] active:scale-95">
                            Create Account
                        </button>
                        <div class="text-center">
                            <p class="text-sm font-bold text-slate-500">
                                Already a member? 
                                <button type="button" class="text-sky-600 underline underline-offset-4 ml-1" onclick="swapForm('login')">Sign In</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop bg-slate-900/60 transition-opacity duration-300"><button>close</button></form>
</dialog>

<?php include('../includes/footer.php'); ?>