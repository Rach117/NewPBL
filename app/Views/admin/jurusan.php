<?php include __DIR__.'/../partials/sidebar.php'; ?>

<div class="p-8 max-w-5xl mx-auto">
    <div class="mb-2">
        <a href="/master" class="text-slate-500 hover:text-blue-600 text-sm flex items-center font-medium transition-colors">
            <span class="material-icons text-sm mr-1">arrow_back</span> Kembali ke Menu Utama
        </a>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Master Data Jurusan</h1>
            <p class="text-slate-500 mt-1">Daftar referensi Program Studi dan Unit Kerja.</p>
        </div>
        <button class="inline-flex items-center px-5 py-2.5 bg-blue-700 text-white text-sm font-bold rounded-lg shadow-lg hover:bg-blue-800 hover:-translate-y-0.5 transition-all">
            <span class="material-icons text-sm mr-2">add</span> Tambah Jurusan
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 w-16 text-center">ID</th>
                        <th class="px-6 py-4">Nama Jurusan / Unit</th>
                        <th class="px-6 py-4 text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if(empty($jurusan)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                                <span class="material-icons text-4xl mb-2 block">folder_off</span>
                                Belum ada data jurusan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($jurusan as $j): ?>
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 text-center text-slate-400 font-mono text-xs bg-slate-50/50">
                                <?php echo $j['id']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700 text-base group-hover:text-blue-700 transition-colors">
                                    <?php echo htmlspecialchars($j['nama_jurusan']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all" title="Edit">
                                        <span class="material-icons text-sm">edit</span>
                                    </button>
                                    <button class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all" title="Hapus">
                                        <span class="material-icons text-sm">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="bg-slate-50 px-6 py-3 border-t border-slate-200 text-xs text-slate-500 font-medium flex justify-between">
            <span>Menampilkan seluruh data aktif.</span>
            <span>Total: <strong><?php echo count($jurusan ?? []); ?></strong> Unit</span>
        </div>
    </div>
</div>
<?php include __DIR__.'/../partials/footer.php'; ?>