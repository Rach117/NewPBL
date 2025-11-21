<?php include __DIR__.'/../partials/sidebar.php'; ?>

<div class="p-8 max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Daftar Pengajuan Telaah</h1>
            <p class="text-slate-500 mt-1">Kelola draft dan pantau status pengajuan Anda.</p>
        </div>
        <a href="/telaah/create" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 transition-all">
            <span class="material-icons text-sm mr-2">add</span> Buat Baru
        </a>
    </div>

    <?php if (empty($telaah_list)): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-16 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 mb-6">
                <span class="material-icons text-slate-300 text-4xl">folder_open</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Pengajuan</h3>
            <p class="text-slate-500 mb-6">Mulai buat pengajuan telaah pertama Anda sekarang.</p>
            <a href="/telaah/create" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">
                <span class="material-icons text-sm mr-2">add</span> Buat Pengajuan Telaah
            </a>
        </div>
    <?php else: ?>
        <div class="grid gap-6">
            <?php foreach ($telaah_list as $t): 
                $statusColor = match($t['status_telaah']) {
                    'Draft' => 'bg-slate-100 text-slate-700 border-slate-200',
                    'Diajukan' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'Revisi' => 'bg-amber-100 text-amber-700 border-amber-200',
                    'Disetujui' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    'Ditolak' => 'bg-rose-100 text-rose-700 border-rose-200',
                    default => 'bg-slate-100 text-slate-700 border-slate-200'
                };
            ?>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-xl font-bold text-slate-800">
                                <?php echo htmlspecialchars($t['nama_kegiatan']); ?>
                            </h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border <?php echo $statusColor; ?>">
                                <?php echo $t['status_telaah']; ?>
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 line-clamp-2">
                            <?php echo htmlspecialchars(substr($t['gambaran_umum'], 0, 150)) . '...'; ?>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 pb-4 border-b border-slate-100">
                <div>
                    <div class="text-xs text-slate-400 uppercase font-bold mb-1">Penerima Manfaat</div>
                    <div class="text-sm font-bold text-slate-700"><?php echo htmlspecialchars($t['penerima_manfaat']); ?></div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 uppercase font-bold mb-1">Tanggal Mulai</div>
                    <div class="text-sm font-bold text-slate-700"><?php echo date('d M Y', strtotime($t['tanggal_mulai'])); ?></div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 uppercase font-bold mb-1">Tanggal Selesai</div>
                    <div class="text-sm font-bold text-slate-700"><?php echo date('d M Y', strtotime($t['tanggal_selesai'])); ?></div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 uppercase font-bold mb-1">Estimasi Anggaran</div>
                    <div class="text-sm font-bold text-emerald-600">Rp <?php echo number_format($t['total_anggaran'] ?? 0, 0, ',', '.'); ?></div>
                </div>
            </div>

            <?php if (!empty($t['catatan_verifikator'])): ?>
            <div class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                <div class="text-xs font-bold text-amber-800 mb-1">
                    <span class="material-icons text-xs align-middle">comment</span> Catatan Verifikator:
                </div>
                <div class="text-sm text-amber-700"><?php echo htmlspecialchars($t['catatan_verifikator']); ?></div>
            </div>
            <?php endif; ?>

            <div class="flex gap-3">
                <?php if ($t['status_telaah'] === 'Draft'): ?>
                    <a href="/telaah/create?id=<?php echo $t['id']; ?>" 
                       class="flex-1 flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors">
                        <span class="material-icons text-sm mr-2">edit</span> Lanjutkan Edit
                    </a>
                    <form method="POST" action="/telaah/delete" onsubmit="return confirm('Hapus draft ini?')" class="flex-1">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-white border-2 border-rose-300 text-rose-600 text-sm font-bold rounded-lg hover:bg-rose-50 transition-colors">
                            <span class="material-icons text-sm mr-2">delete</span> Hapus Draft
                        </button>
                    </form>
                <?php elseif ($t['status_telaah'] === 'Revisi'): ?>
                    <a href="/telaah/create?id=<?php echo $t['id']; ?>" 
                       class="flex-1 flex items-center justify-center px-4 py-2 bg-amber-600 text-white text-sm font-bold rounded-lg hover:bg-amber-700 transition-colors">
                        <span class="material-icons text-sm mr-2">edit</span> Perbaiki & Ajukan Ulang
                    </a>
                <?php elseif ($t['status_telaah'] === 'Disetujui'): ?>
                    <a href="/usulan/create-from-telaah?telaah_id=<?php echo $t['id']; ?>" 
                       class="flex-1 flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition-colors">
                        <span class="material-icons text-sm mr-2">arrow_forward</span> Buat Usulan Kegiatan
                    </a>
                <?php else: ?>
                    <div class="flex-1 flex items-center justify-center px-4 py-2 bg-slate-100 text-slate-500 text-sm font-bold rounded-lg cursor-not-allowed">
                        <span class="material-icons text-sm mr-2">lock</span> Tidak Bisa Diedit
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>
<?php include __DIR__.'/../partials/footer.php'; ?>