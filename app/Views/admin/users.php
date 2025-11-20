<?php include __DIR__.'/../partials/sidebar.php'; ?>

<div class="p-8 max-w-7xl mx-auto">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Pengguna</h1>
            <p class="text-slate-500 mt-1">Kelola akses, peran, dan keamanan akun pengguna sistem.</p>
        </div>
        <button onclick="openModal('modalUser')" class="inline-flex items-center px-5 py-2.5 bg-blue-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-blue-700/30 hover:bg-blue-800 hover:-translate-y-0.5 transition-all">
            <span class="material-icons text-sm mr-2">person_add</span> Tambah User Baru
        </button>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <span class="material-icons absolute left-3 top-2.5 text-slate-400 text-sm">search</span>
                <input type="text" name="search" placeholder="Cari nama atau email..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm outline-none">
            </div>
            <div class="flex-1 relative">
                <span class="material-icons absolute left-3 top-2.5 text-slate-400 text-sm">filter_list</span>
                <select name="jurusan" class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm outline-none bg-white appearance-none text-slate-600 cursor-pointer">
                    <option value="">Semua Unit / Jurusan</option>
                    <?php foreach ($jurusan as $j): ?>
                        <option value="<?php echo $j['id']; ?>" <?php echo (($_GET['jurusan'] ?? '') == $j['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($j['nama_jurusan']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-slate-800 text-white font-bold rounded-lg hover:bg-slate-900 transition-colors text-sm">
                Terapkan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 w-16">Avatar</th>
                        <th class="px-6 py-4">Identitas Akun</th>
                        <th class="px-6 py-4">Role & Unit</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($users as $u): ?>
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                <?php echo strtoupper(substr($u['username'], 0, 1)); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 text-base mb-0.5 group-hover:text-blue-700 transition-colors">
                                <?php echo htmlspecialchars($u['username']); ?>
                            </div>
                            <div class="text-xs text-slate-500 flex items-center">
                                <span class="material-icons text-[10px] mr-1">email</span>
                                <?php echo htmlspecialchars($u['email']); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-2.5 py-0.5 rounded text-xs font-bold border bg-slate-50 border-slate-200 text-slate-600 mb-1">
                                <?php echo htmlspecialchars($u['role']); ?>
                            </span>
                            <div class="text-xs text-slate-500">
                                <?php echo $u['nama_jurusan'] ? htmlspecialchars($u['nama_jurusan']) : '-'; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if ($u['is_active']): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wide">
                                    Aktif
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100 uppercase tracking-wide">
                                    Nonaktif
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="post" action="/users/delete" onsubmit="return confirm('Nonaktifkan user ini?');" class="inline-block">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                                <button class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all" title="Hapus User">
                                    <span class="material-icons text-sm">block</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="bg-slate-50 px-6 py-3 border-t border-slate-200 text-xs text-slate-500 font-medium flex justify-between">
            <span>Total Pengguna: <strong><?php echo count($users); ?></strong></span>
        </div>
    </div>
</div>

<div id="modalUser" class="fixed inset-0 z-[99] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="closeModal('modalUser')"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">
            
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800 flex items-center">
                    <span class="material-icons text-blue-600 mr-2">person_add</span> Tambah Pengguna
                </h3>
                <button type="button" onclick="closeModal('modalUser')" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <span class="material-icons">close</span>
                </button>
            </div>

            <form action="/users/create" method="POST" class="p-6 space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Username</label>
                        <input type="text" name="username" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none text-sm font-medium" placeholder="namauser">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email</label>
                        <input type="email" name="email" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none text-sm" placeholder="user@pnj.ac.id">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password</label>
                        <input type="password" name="password" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none text-sm" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Role</label>
                        <select name="role" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none text-sm bg-white">
                            <option value="Pengusul">Pengusul</option>
                            <option value="Verifikator">Verifikator</option>
                            <option value="WD2">WD2</option>
                            <option value="PPK">PPK</option>
                            <option value="Bendahara">Bendahara</option>
                            <option value="Direktur">Direktur</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Unit / Jurusan</label>
                        <select name="jurusan_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none text-sm bg-white">
                            <option value="">- Pusat / General -</option>
                            <?php foreach ($jurusan as $j): ?>
                                <option value="<?php echo $j['id']; ?>"><?php echo htmlspecialchars($j['nama_jurusan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="button" onclick="closeModal('modalUser')" class="flex-1 px-4 py-2.5 border border-slate-300 text-slate-600 font-bold rounded-lg hover:bg-slate-50 text-sm transition-colors">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 text-sm shadow-md transition-colors">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>

<?php include __DIR__.'/../partials/footer.php'; ?>