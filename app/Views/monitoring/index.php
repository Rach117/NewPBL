<?php include __DIR__.'/../partials/sidebar.php'; ?>

<div class="p-8 max-w-7xl mx-auto">
    
    <div class="relative bg-slate-900 rounded-2xl p-8 mb-8 shadow-xl overflow-hidden text-white">
        <div class="absolute left-0 top-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-blue-600 rounded-full blur-[80px] opacity-20"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight mb-2">Monitoring Kegiatan</h1>
                <p class="text-slate-400 text-sm max-w-xl">Pantau status real-time seluruh usulan, mulai dari draft hingga penyelesaian laporan pertanggungjawaban.</p>
            </div>
            <div class="flex items-center gap-3 bg-slate-800/50 p-2 rounded-lg border border-slate-700 backdrop-blur-sm">
                <div class="px-4 border-r border-slate-700">
                    <span class="block text-xs text-slate-500 uppercase font-bold">Total Usulan</span>
                    <span class="block text-xl font-bold text-white"><?php echo isset($total) ? $total : count($usulan); ?></span>
                </div>
                <div class="px-2">
                    <span class="material-icons text-emerald-500 animate-pulse">radio_button_checked</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6 sticky top-4 z-20">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-5 relative">
                <span class="material-icons absolute left-3 top-2.5 text-slate-400 text-sm">search</span>
                <input type="text" name="q" placeholder="Cari Nama Kegiatan / Pengusul..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition-all">
            </div>

            <div class="md:col-span-3 relative">
                <span class="material-icons absolute left-3 top-2.5 text-slate-400 text-sm">filter_alt</span>
                <select name="status" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none cursor-pointer text-slate-600">
                    <option value="">Semua Status</option>
                    <option value="Verifikasi">Verifikasi</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Pencairan">Pencairan</option>
                    <option value="LPJ">Proses LPJ</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <input type="date" name="date" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm text-slate-600">
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="w-full py-2 bg-slate-800 text-white font-bold rounded-lg hover:bg-slate-900 transition-all text-sm flex items-center justify-center shadow-md">
                    Filter Data
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <?php if (empty($usulan)): ?>
            <div class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4">
                    <span class="material-icons text-slate-300 text-3xl">search_off</span>
                </div>
                <h3 class="text-lg font-bold text-slate-700">Data Tidak Ditemukan</h3>
                <p class="text-slate-500 text-sm">Coba sesuaikan filter pencarian Anda.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-xs border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 w-20">ID</th>
                            <th class="px-6 py-4">Detail Kegiatan</th>
                            <th class="px-6 py-4">Status & Posisi</th>
                            <th class="px-6 py-4">Timeline</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($usulan as $row): 
                            // Logic Warna Status Elite
                            $s = $row['status_terkini'];
                            $badgeClass = match($s) {
                                'Selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'Ditolak' => 'bg-rose-100 text-rose-700 border-rose-200',
                                'Pencairan', 'LPJ' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'Verifikasi' => 'bg-amber-100 text-amber-700 border-amber-200',
                                default => 'bg-slate-100 text-slate-600 border-slate-200'
                            };
                            
                            // Logic Keterlambatan
                            $isLate = false;
                            if (!empty($row['tgl_batas_lpj']) && $s !== 'Selesai') {
                                $deadline = new DateTime($row['tgl_batas_lpj']);
                                $now = new DateTime();
                                if ($now > $deadline) $isLate = true;
                            }
                        ?>
                        <tr class="hover:bg-slate-50 transition-colors group <?php echo $isLate ? 'bg-rose-50/30' : ''; ?>">
                            <td class="px-6 py-4 font-mono text-slate-400 text-xs">
                                #<?php echo $row['id']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 text-base mb-1 group-hover:text-blue-700 transition-colors">
                                    <?php echo htmlspecialchars($row['nama_kegiatan']); ?>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="flex items-center"><span class="material-icons text-[10px] mr-1">person</span> <?php echo htmlspecialchars($row['username']); ?></span>
                                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                    <span class="font-medium text-emerald-600">Rp <?php echo number_format($row['nominal_pencairan'], 0, ',', '.'); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold border <?php echo $badgeClass; ?>">
                                    <?php if($s=='Selesai'): ?><span class="material-icons text-[10px] mr-1">verified</span><?php endif; ?>
                                    <?php echo $s; ?>
                                </span>
                                <?php if($isLate): ?>
                                    <div class="mt-1 text-[10px] font-bold text-rose-600 flex items-center animate-pulse">
                                        <span class="material-icons text-[10px] mr-1">warning</span> Overdue
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($row['tgl_batas_lpj']): ?>
                                    <div class="text-xs text-slate-500">
                                        <div class="mb-1 text-slate-400">Batas LPJ:</div>
                                        <div class="font-mono font-bold <?php echo $isLate ? 'text-rose-600' : 'text-slate-700'; ?>">
                                            <?php echo date('d M Y', strtotime($row['tgl_batas_lpj'])); ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span class="text-xs text-slate-400 italic">- Belum dijadwalkan -</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="/usulan/detail?id=<?php echo $row['id']; ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition-all" title="Lihat Detail">
                                    <span class="material-icons text-sm">visibility</span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-between items-center">
                <div class="text-xs text-slate-500 font-medium">
                    Menampilkan halaman <?php echo $page; ?>
                </div>
                <div class="flex gap-1">
                    <?php $totalPages = ceil(($total ?? 0) / 10); ?>
                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                        <a href="/monitoring?page=<?php echo $p; ?>" class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-bold transition-all <?php echo ($p == $page) ? 'bg-slate-800 text-white shadow-md transform scale-105' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-200'; ?>">
                            <?php echo $p; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include __DIR__.'/../partials/footer.php'; ?>