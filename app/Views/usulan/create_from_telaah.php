<?php include __DIR__.'/../partials/sidebar.php'; ?>

<div class="p-8 max-w-5xl mx-auto">
    <div class="mb-6">
        <a href="/telaah/list" class="text-slate-500 hover:text-blue-600 text-sm flex items-center font-medium">
            <span class="material-icons text-sm mr-1">arrow_back</span> Kembali ke Daftar Telaah
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Buat Usulan Kegiatan</h1>
            <p class="text-slate-500">Lengkapi informasi tambahan untuk mengaktifkan telaah menjadi usulan kegiatan resmi</p>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
            <div class="flex items-start">
                <span class="material-icons text-blue-600 mr-3">info</span>
                <div class="flex-1">
                    <div class="font-bold text-blue-900 mb-1">Telaah yang dipilih:</div>
                    <div class="text-blue-800"><?php echo htmlspecialchars($telaah['nama_kegiatan']); ?></div>
                    <div class="text-sm text-blue-700 mt-2">
                        <strong>Estimasi Anggaran:</strong> Rp <?php echo number_format($total_anggaran, 0, ',', '.'); ?>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="/usulan/store-from-telaah" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="telaah_id" value="<?php echo $telaah['id']; ?>">

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Nama Penanggung Jawab <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="penanggung_jawab" required 
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Nama lengkap penanggung jawab kegiatan">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Waktu Pelaksanaan Mulai <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="waktu_mulai" required 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Waktu Pelaksanaan Selesai <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="waktu_selesai" required 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Surat Pengantar (PDF, Max 5MB) <span class="text-rose-500">*</span>
                    </label>
                    <input type="file" name="surat_pengantar" accept=".pdf" required 
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <p class="text-xs text-slate-500 mt-2">Upload surat pengantar dari Ketua Jurusan/Unit</p>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <a href="/telaah/list" class="flex-1 px-6 py-3 bg-white border-2 border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 text-center">
                    Batal
                </a>
                <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg">
                    <span class="material-icons text-sm align-middle mr-2">send</span>
                    Ajukan ke WD2
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__.'/../partials/footer.php'; ?>