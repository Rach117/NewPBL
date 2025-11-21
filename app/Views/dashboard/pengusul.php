<?php include __DIR__.'/../partials/sidebar.php'; ?>

<div class="p-8 max-w-7xl mx-auto">
    <div class="relative bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl p-10 text-white shadow-2xl mb-10 overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -mr-16 -mt-16"></div>
        <div class="relative z-10">
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 border border-white/30 text-white text-xs font-bold mb-3">
                <span class="material-icons text-sm mr-2">verified</span> Akun Pengusul Aktif
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight mb-2">Halo, Pengusul!</h1>
            <p class="text-blue-50 text-lg max-w-2xl">Realisasikan ide kegiatan akademik Anda. Kami siap memfasilitasi pengajuan anggaran yang transparan dan cepat.</p>
            
            <div class="mt-8 flex gap-4">
                <!-- DROPDOWN BUAT PENGAJUAN -->
                <div class="relative group">
                    <button class="flex items-center px-6 py-3 bg-white text-blue-700 font-bold rounded-lg shadow-lg hover:bg-blue-50 hover:-translate-y-1 transition-all">
                        <span class="material-icons mr-2">add_circle</span> Buat Pengajuan
                        <span class="material-icons ml-2 text-sm">expand_more</span>
                    </button>
                    <div class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                        <a href="/telaah/create" class="flex items-center px-4 py-3 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-medium border-b border-slate-100 rounded-t-lg transition-colors">
                            <span class="material-icons text-sm mr-3 text-blue-600">description</span>
                            <div>
                                <div class="font-bold">Pengajuan Telaah</div>
                                <div class="text-xs text-slate-500">Draft KAK, IKU & RAB</div>
                            </div>
                        </a>
                        <a href="#" onclick="alert('Fitur segera hadir!'); return false;" class="flex items-center px-4 py-3 hover:bg-slate-50 text-slate-400 font-medium border-b border-slate-100 cursor-not-allowed">
                            <span class="material-icons text-sm mr-3">event_note</span>
                            <div>
                                <div class="font-bold">Pengajuan Kegiatan</div>
                                <div class="text-xs">Coming Soon</div>
                            </div>
                        </a>
                        <a href="#" onclick="alert('Fitur segera hadir!'); return false;" class="flex items-center px-4 py-3 hover:bg-slate-50 text-slate-400 font-medium rounded-b-lg cursor-not-allowed">
                            <span class="material-icons text-sm mr-3">receipt_long</span>
                            <div>
                                <div class="font-bold">Pengajuan LPJ</div>
                                <div class="text-xs">Coming Soon</div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <a href="/monitoring" class="px-6 py-3 bg-blue-700/50 text-white border border-white/30 font-bold rounded-lg hover:bg-blue-700 transition-all flex items-center">
                    <span class="material-icons mr-2">visibility</span> Monitoring
                </a>
            </div>
        </div>
    </div>

    <h3 class="text-lg font-bold text-slate-800 mb-6 border-l-4 border-blue-500 pl-3">Menu Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <a href="/telaah/list" class="group bg-white p-6 rounded-xl shadow-sm border border-slate-200 hover:shadow-xl hover:border-blue-300 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110">
                <span class="material-icons text-8xl text-blue-600">description</span>
            </div>
            <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <span class="material-icons text-2xl">edit_document</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-blue-700">Buat Telaah Baru</h3>
            <p class="text-slate-500 text-sm">Mulai draft KAK, IKU dan RAB untuk kegiatan mendatang.</p>
        </a>

        <a href="/monitoring" class="group bg-white p-6 rounded-xl shadow-sm border border-slate-200 hover:shadow-xl hover:border-cyan-300 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110">
                <span class="material-icons text-8xl text-cyan-600">visibility</span>
            </div>
            <div class="w-14 h-14 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center mb-4 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                <span class="material-icons text-2xl">search</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-cyan-700">Lacak Status</h3>
            <p class="text-slate-500 text-sm">Pantau posisi dokumen Anda di meja verifikator atau pimpinan.</p>
        </a>

        <a href="/notifikasi" class="group bg-white p-6 rounded-xl shadow-sm border border-slate-200 hover:shadow-xl hover:border-amber-300 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110">
                <span class="material-icons text-8xl text-amber-600">notifications</span>
            </div>
            <div class="w-14 h-14 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                <span class="material-icons text-2xl">mail</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-amber-700">Kotak Masuk</h3>
            <p class="text-slate-500 text-sm">Cek pesan revisi atau instruksi dari pimpinan.</p>
        </a>
    </div>
</div>
<?php include __DIR__.'/../partials/footer.php'; ?>