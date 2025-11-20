<?php include __DIR__.'/../partials/sidebar.php'; ?>

<div class="p-8 max-w-6xl mx-auto">
    <div class="mb-2">
        <a href="/master" class="text-slate-500 hover:text-blue-600 text-sm flex items-center font-medium transition-colors">
            <span class="material-icons text-sm mr-1">arrow_back</span> Kembali ke Menu Utama
        </a>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Indikator Kinerja (IKU)</h1>
            <p class="text-slate-500 mt-1">Referensi indikator kinerja untuk pengajuan kegiatan.</p>
        </div>
        <button class="inline-flex items-center px-5 py-2.5 bg-emerald-600 text-white text-sm font-bold rounded-lg shadow-lg hover:bg-emerald-700 hover:-translate-y-0.5 transition-all">
            <span class="material-icons text-sm mr-2">playlist_add</span> Tambah IKU Baru
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 w-12 text-center">No</th>
                        <th class="px-6 py-4">Deskripsi Indikator</th>
                        <th class="px-6 py-4 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if(empty($iku)): ?>
                         <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                                <span class="material-icons text-4xl mb-2 block">assignment_late</span>
                                Belum ada data IKU.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($iku as $index => $i): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-center text-slate-400 font-mono text-xs">
                                <?php echo $index + 1; ?>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-700 font-medium leading-relaxed"><?php echo htmlspecialchars($i['deskripsi_iku']); ?></p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="text-slate-400 hover:text-blue-600 transition-colors p-1"><span class="material-icons text-sm">edit</span></button>
                                    <button class="text-slate-400 hover:text-rose-600 transition-colors p-1"><span class="material-icons text-sm">delete</span></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include __DIR__.'/../partials/footer.php'; ?>