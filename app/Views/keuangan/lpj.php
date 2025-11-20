<?php include __DIR__.'/../../Views/partials/sidebar.php'; ?>

<div class="p-8 max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Verifikasi LPJ</h1>
        <p class="text-slate-500 mt-1">Monitoring pertanggungjawaban kegiatan yang telah dicairkan.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-xs border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Kegiatan</th>
                    <th class="px-6 py-4">Deadline LPJ</th>
                    <th class="px-6 py-4 text-center">Status Dokumen</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($usulan as $row): 
                    // Hitung sisa hari
                    $deadline = new DateTime($row['tgl_batas_lpj']);
                    $today = new DateTime();
                    $interval = $today->diff($deadline);
                    $daysLeft = (int)$interval->format('%r%a');
                    $isLate = $daysLeft < 0;
                ?>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800 mb-1"><?php echo htmlspecialchars($row['nama_kegiatan']); ?></div>
                        <div class="text-xs text-slate-500"><?php echo htmlspecialchars($row['username']); ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center font-mono font-bold <?php echo $isLate ? 'text-rose-600' : ($daysLeft < 3 ? 'text-amber-600' : 'text-emerald-600'); ?>">
                            <span class="material-icons text-xs mr-2">timer</span>
                            <?php echo date('d M Y', strtotime($row['tgl_batas_lpj'])); ?>
                        </div>
                        <div class="text-[10px] font-bold mt-1 uppercase tracking-wide <?php echo $isLate ? 'text-rose-500' : 'text-slate-400'; ?>">
                            <?php echo $isLate ? 'Terlambat ' . abs($daysLeft) . ' Hari' : $daysLeft . ' Hari Tersisa'; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?php if ($row['status_terkini'] === 'LPJ'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold border border-blue-200">
                                <span class="material-icons text-[10px] mr-1">upload_file</span> Uploaded
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold border border-slate-200">
                                <span class="material-icons text-[10px] mr-1">hourglass_empty</span> Menunggu
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="/usulan/detail?id=<?php echo $row['id']; ?>" class="p-2 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 hover:border-blue-300 transition-colors" title="Lihat Dokumen">
                                <span class="material-icons text-lg">visibility</span>
                            </a>
                            
                            <a href="/pdf/berita_acara?id=<?php echo $row['id']; ?>" target="_blank" class="p-2 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-slate-800 hover:border-slate-400 transition-colors" title="Cetak BA">
                                <span class="material-icons text-lg">print</span>
                            </a>

                            <?php if ($row['status_terkini'] === 'LPJ'): ?>
                                <form method="post" action="/lpj/verifikasi?id=<?php echo $row['id']; ?>" onsubmit="return confirm('Finalisasi kegiatan ini? Pastikan hardcopy sudah diterima.');">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-lg shadow hover:bg-emerald-700 transition-all">
                                        <span class="material-icons text-sm mr-2">verified</span> Selesai
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__.'/../../Views/partials/footer.php'; ?>