<?php include __DIR__.'/../partials/sidebar.php'; ?>

<div class="p-8 max-w-6xl mx-auto">
    
    <!-- Header -->
    <div class="text-center mb-10">
        <a href="/telaah/list" class="text-slate-500 hover:text-blue-600 text-sm flex items-center justify-center font-medium mb-4">
            <span class="material-icons text-sm mr-1">arrow_back</span> Kembali ke Daftar Telaah
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Pengajuan Telaah</h1>
        <p class="text-slate-500">Lengkapi formulir KAK, IKU, dan RAB secara bertahap</p>
    </div>

    <!-- Stepper Indicator -->
    <div class="flex items-center justify-center mb-12">
        <div class="flex items-center">
            <!-- Step 1 -->
            <div class="flex flex-col items-center">
                <div id="step-1-circle" class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold shadow-lg ring-4 ring-blue-50 transition-all">
                    1
                </div>
                <span id="step-1-label" class="text-xs font-bold mt-2 text-blue-600">KAK</span>
            </div>
            <div id="line-1" class="w-24 h-1 bg-slate-200 mx-2 rounded transition-all"></div>
            
            <!-- Step 2 -->
            <div class="flex flex-col items-center">
                <div id="step-2-circle" class="w-12 h-12 rounded-full bg-white text-slate-400 border-2 border-slate-200 flex items-center justify-center font-bold transition-all">
                    2
                </div>
                <span id="step-2-label" class="text-xs font-bold mt-2 text-slate-400">IKU</span>
            </div>
            <div id="line-2" class="w-24 h-1 bg-slate-200 mx-2 rounded transition-all"></div>
            
            <!-- Step 3 -->
            <div class="flex flex-col items-center">
                <div id="step-3-circle" class="w-12 h-12 rounded-full bg-white text-slate-400 border-2 border-slate-200 flex items-center justify-center font-bold transition-all">
                    3
                </div>
                <span id="step-3-label" class="text-xs font-bold mt-2 text-slate-400">RAB</span>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <form id="telaahForm" class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="telaah_id" id="telaahId" value="<?php echo $telaah['id'] ?? ''; ?>">

        <!-- STEP 1: KAK -->
        <div id="step-1" class="step-content">
            <div class="flex items-center mb-6 pb-4 border-b border-slate-100">
                <span class="material-icons text-blue-600 mr-3">description</span>
                <h2 class="text-xl font-bold text-slate-800">Kerangka Acuan Kegiatan (KAK)</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kegiatan *</label>
                    <input type="text" name="nama_kegiatan" required
                           value="<?php echo htmlspecialchars($telaah['nama_kegiatan'] ?? ''); ?>"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                           placeholder="Contoh: Workshop Pengembangan SDM">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Gambaran Umum *</label>
                    <textarea name="gambaran_umum" required rows="4"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                              placeholder="Jelaskan latar belakang dan tujuan kegiatan..."><?php echo htmlspecialchars($telaah['gambaran_umum'] ?? ''); ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Penerima Manfaat *</label>
                    <input type="text" name="penerima_manfaat" required
                           value="<?php echo htmlspecialchars($telaah['penerima_manfaat'] ?? ''); ?>"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Contoh: 50 Mahasiswa TI">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Strategi Pencapaian Keluaran</label>
                    <input type="text" name="strategi_pencapaian"
                           value="<?php echo htmlspecialchars($telaah['strategi_pencapaian'] ?? ''); ?>"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Strategi yang akan digunakan">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Metode Pelaksanaan</label>
                    <input type="text" name="metode_pelaksanaan"
                           value="<?php echo htmlspecialchars($telaah['metode_pelaksanaan'] ?? ''); ?>"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Metode yang digunakan">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tahapan Pelaksanaan</label>
                    <textarea name="tahapan_pelaksanaan" rows="3"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Tahap 1: Persiapan&#10;Tahap 2: Pelaksanaan&#10;Tahap 3: Evaluasi"><?php echo htmlspecialchars($telaah['tahapan_pelaksanaan'] ?? ''); ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        <span class="material-icons text-xs align-middle">calendar_today</span> Tanggal Mulai *
                    </label>
                    <input type="date" name="tanggal_mulai" required
                           value="<?php echo $telaah['tanggal_mulai'] ?? ''; ?>"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        <span class="material-icons text-xs align-middle">calendar_today</span> Tanggal Selesai *
                    </label>
                    <input type="date" name="tanggal_selesai" required
                           value="<?php echo $telaah['tanggal_selesai'] ?? ''; ?>"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
            </div>

            <!-- Indikator Kinerja -->
            <div class="mt-8 pt-8 border-t border-slate-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-slate-800">Indikator Kinerja</h3>
                    <button type="button" onclick="addIndikator()" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700">
                        <span class="material-icons text-sm mr-1">add</span> Tambah
                    </button>
                </div>

                <div id="indikatorContainer" class="space-y-3">
                    <?php if (!empty($indikators)): ?>
                        <?php foreach ($indikators as $ind): ?>
                            <div class="indikator-row flex gap-3 items-start p-4 bg-slate-50 rounded-xl">
                                <div class="flex-1">
                                    <input type="text" name="indikator_keberhasilan[]"
                                           value="<?php echo htmlspecialchars($ind['indikator_keberhasilan']); ?>"
                                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm mb-2"
                                           placeholder="Indikator Keberhasilan">
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" name="bulan_target[]"
                                               value="<?php echo htmlspecialchars($ind['bulan_target']); ?>"
                                               class="px-3 py-2 border border-slate-300 rounded-lg text-sm"
                                               placeholder="Bulan Target (cth: Januari 2025)">
                                        <input type="number" name="bobot_persen[]"
                                               value="<?php echo $ind['bobot_persen']; ?>"
                                               class="px-3 py-2 border border-slate-300 rounded-lg text-sm"
                                               placeholder="Bobot (%)" min="0" max="100" step="0.01">
                                    </div>
                                </div>
                                <button type="button" onclick="removeIndikator(this)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                    <span class="material-icons text-sm">delete</span>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="indikator-row flex gap-3 items-start p-4 bg-slate-50 rounded-xl">
                            <div class="flex-1">
                                <input type="text" name="indikator_keberhasilan[]"
                                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm mb-2"
                                       placeholder="Indikator Keberhasilan">
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="bulan_target[]"
                                           class="px-3 py-2 border border-slate-300 rounded-lg text-sm"
                                           placeholder="Bulan Target (cth: Januari 2025)">
                                    <input type="number" name="bobot_persen[]"
                                           class="px-3 py-2 border border-slate-300 rounded-lg text-sm"
                                           placeholder="Bobot (%)" min="0" max="100" step="0.01">
                                </div>
                            </div>
                            <button type="button" onclick="removeIndikator(this)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                <span class="material-icons text-sm">delete</span>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- STEP 2: IKU -->
        <div id="step-2" class="step-content hidden">
            <div class="flex items-center mb-6 pb-4 border-b border-slate-100">
                <span class=" material-icons text-emerald-600 mr-3">analytics</span>
        <h2 class="text-xl font-bold text-slate-800">Target IKU & Renstra</h2>
        </div>
        <div class="flex justify-between items-center mb-4">
            <p class="text-sm text-slate-600">Pilih indikator kinerja utama yang relevan dengan kegiatan Anda</p>
            <button type="button" onclick="addIku()" class="flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700">
                <span class="material-icons text-sm mr-1">add</span> Tambah IKU
            </button>
        </div>

        <div id="ikuContainer" class="space-y-4">
            <?php if (!empty($ikus)): ?>
                <?php foreach ($ikus as $iku): ?>
                    <div class="iku-row flex gap-3 items-center p-4 bg-slate-50 rounded-xl">
                        <div class="flex-1 grid grid-cols-2 gap-3">
                            <select name="iku_ids[]" class="px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                <option value="">-- Pilih IKU --</option>
                                <?php foreach ($master_iku as $m): ?>
                                    <option value="<?php echo $m['id']; ?>" <?php echo ($m['id'] == $iku['iku_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($m['deskripsi_iku']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="iku_targets[]"
                                   value="<?php echo htmlspecialchars($iku['target_value'] ?? ''); ?>"
                                   class="px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"
                                   placeholder="Target Nilai/Capaian">
                        </div>
                        <button type="button" onclick="removeIku(this)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                            <span class="material-icons text-sm">delete</span>
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="iku-row flex gap-3 items-center p-4 bg-slate-50 rounded-xl">
                    <div class="flex-1 grid grid-cols-2 gap-3">
                        <select name="iku_ids[]" class="px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <option value="">-- Pilih IKU --</option>
                            <?php foreach ($master_iku as $m): ?>
                                <option value="<?php echo $m['id']; ?>"><?php echo htmlspecialchars($m['deskripsi_iku']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="iku_targets[]"
                               class="px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"
                               placeholder="Target Nilai/Capaian">
                    </div>
                    <button type="button" onclick="removeIku(this)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                        <span class="material-icons text-sm">delete</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
            <p class="text-sm text-blue-800">
                <strong>💡 Tips:</strong> Pilih IKU yang paling relevan dengan tujuan kegiatan. Target nilai harus realistis dan terukur.
            </p>
        </div>
    </div>

    <!-- STEP 3: RAB -->
    <div id="step-3" class="step-content hidden">
        <div class="flex items-center mb-6 pb-4 border-b border-slate-100">
            <span class="material-icons text-amber-600 mr-3">payments</span>
            <h2 class="text-xl font-bold text-slate-800">Rencana Anggaran Biaya (RAB)</h2>
        </div>

        <div class="flex justify-between items-center mb-4">
            <p class="text-sm text-slate-600">Rincian kebutuhan anggaran untuk pelaksanaan kegiatan</p>
            <button type="button" onclick="addRab()" class="flex items-center px-4 py-2 bg-amber-600 text-white text-sm font-bold rounded-lg hover:bg-amber-700">
                <span class="material-icons text-sm mr-1">add</span> Tambah Item
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-3 py-3 text-left">Kategori</th>
                        <th class="px-3 py-3 text-left">Uraian</th>
                        <th class="px-3 py-3 text-center w-20">Vol</th>
                        <th class="px-3 py-3 text-center w-28">Satuan</th>
                        <th class="px-3 py-3 text-right w-32">Harga (@)</th>
                        <th class="px-3 py-3 text-right w-32">Total</th>
                        <th class="px-3 py-3 w-12"></th>
                    </tr>
                </thead>
                <tbody id="rabContainer" class="divide-y divide-slate-100">
                    <?php if (!empty($rabs)): ?>
                        <?php foreach ($rabs as $rab): ?>
                            <tr class="rab-row hover:bg-slate-50">
                                <td class="px-3 py-2">
                                    <select name="rab_kategori[]" class="w-full px-2 py-2 border border-slate-300 rounded text-sm">
                                        <option value="">-- Pilih --</option>
                                        <?php foreach ($kategori as $k): ?>
                                            <option value="<?php echo $k['id']; ?>" <?php echo ($k['id'] == $rab['kategori_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($k['nama_kategori']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="px-3 py-2">
                                    <input type="text" name="rab_uraian[]"
                                           value="<?php echo htmlspecialchars($rab['uraian']); ?>"
                                           class="w-full px-2 py-2 border border-slate-300 rounded text-sm" placeholder="Nama item...">
                                </td>
                                <td class="px-3 py-2">
                                    <input type="number" name="rab_volume[]"
                                           value="<?php echo $rab['volume']; ?>"
                                           class="rab-volume w-full px-2 py-2 border border-slate-300 rounded text-sm text-center" min="1" onchange="hitungTotal(this)">
                                </td>
                                <td class="px-3 py-2">
                                    <select name="rab_satuan[]" class="w-full px-2 py-2 border border-slate-300 rounded text-sm">
                                        <option value="unit" <?php echo ($rab['satuan']=='unit')?'selected':''; ?>>unit</option>
                                        <option value="orang" <?php echo ($rab['satuan']=='orang')?'selected':''; ?>>orang</option>
                                        <option value="paket" <?php echo ($rab['satuan']=='paket')?'selected':''; ?>>paket</option>
                                        <option value="kegiatan" <?php echo ($rab['satuan']=='kegiatan')?'selected':''; ?>>kegiatan</option>
                                        <option value="jam" <?php echo ($rab['satuan']=='jam')?'selected':''; ?>>jam</option>
                                        <option value="PP" <?php echo ($rab['satuan']=='PP')?'selected':''; ?>>PP</option>
                                    </select>
                                </td>
                                <td class="px-3 py-2">
                                    <input type="number" name="rab_harga[]"
                                           value="<?php echo $rab['harga_satuan']; ?>"
                                           class="rab-harga w-full px-2 py-2 border border-slate-300 rounded text-sm text-right" min="0" onchange="hitungTotal(this)">
                                </td>
                                <td class="px-3 py-2 text-right font-bold text-slate-700 rab-total">
                                    Rp <?php echo number_format($rab['total'], 0, ',', '.'); ?>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <button type="button" onclick="removeRab(this)" class="p-1 text-red-600 hover:bg-red-50 rounded">
                                        <span class="material-icons text-sm">delete</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="rab-row hover:bg-slate-50">
                            <td class="px-3 py-2">
                                <select name="rab_kategori[]" class="w-full px-2 py-2 border border-slate-300 rounded text-sm">
                                    <option value="">-- Pilih --</option>
                                    <?php foreach ($kategori as $k): ?>
                                        <option value="<?php echo $k['id']; ?>"><?php echo htmlspecialchars($k['nama_kategori']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="px-3 py-2">
                                <input type="text" name="rab_uraian[]" class="w-full px-2 py-2 border border-slate-300 rounded text-sm" placeholder="Nama item...">
                            </td>
                            <td class="px-3 py-2">
                                <input type="number" name="rab_volume[]" value="1" class="rab-volume w-full px-2 py-2 border border-slate-300 rounded text-sm text-center" min="1" onchange="hitungTotal(this)">
                            </td>
                            <td class="px-3 py-2">
                                <select name="rab_satuan[]" class="w-full px-2 py-2 border border-slate-300 rounded text-sm">
                                    <option value="unit">unit</option>
                                    <option value="orang">orang</option>
                                    <option value="paket">paket</option>
                                    <option value="kegiatan">kegiatan</option>
                                    <option value="jam">jam</option>
                                    <option value="PP">PP</option>
                                </select>
                            </td>
                            <td class="px-3 py-2">
                                <input type="number" name="rab_harga[]" value="0" class="rab-harga w-full px-2 py-2 border border-slate-300 rounded text-sm text-right" min="0" onchange="hitungTotal(this)">
                            </td>
                            <td class="px-3 py-2 text-right font-bold text-slate-700 rab-total">
                                Rp 0
                            </td>
                            <td class="px-3 py-2 text-center">
                                <button type="button" onclick="removeRab(this)" class="p-1 text-red-600 hover:bg-red-50 rounded">
                                    <span class="material-icons text-sm">delete</span>
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="bg-slate-50 font-bold">
                    <tr>
                        <td colspan="5" class="px-3 py-4 text-right text-slate-700">TOTAL ANGGARAN:</td>
                        <td id="grandTotal" class="px-3 py-4 text-right text-xl text-emerald-600">Rp 0</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-between items-center mt-8 pt-6 border-t border-slate-100">
        <button type="button" id="prevBtn" onclick="prevStep()" class="flex items-center px-6 py-3 bg-white border-2 border-slate-300 text-slate-700 font-bold rounded-lg hover:bg-slate-50 hidden">
            <span class="material-icons mr-1">chevron_left</span> Sebelumnya
        </button>
        
        <div class="flex gap-3 ml-auto">
            <button type="button" onclick="saveDraft()" class="flex items-center px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-lg hover:bg-slate-200 border-2 border-slate-200">
                <span class="material-icons text-sm mr-2">save</span> Simpan Draft
            </button>
            
            <button type="button" id="nextBtn" onclick="nextStep()" class="flex items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-lg">
                Selanjutnya <span class="material-icons ml-1">chevron_right</span>
            </button>
            
            <button type="button" id="submitBtn" onclick="submitTelaah()" class="hidden flex items-center px-6 py-3 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 shadow-lg">
                <span class="material-icons text-sm mr-2">send</span> Ajukan ke Verifikator
            </button>
        </div>
    </div>
</form>
</div>
<script>
let currentStep = 1;

// Step Navigation
function showStep(step) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
    document.getElementById('step-' + step).classList.remove('hidden');
    
    // Update buttons
    document.getElementById('prevBtn').classList.toggle('hidden', step === 1);
    document.getElementById('nextBtn').classList.toggle('hidden', step === 3);
    document.getElementById('submitBtn').classList.toggle('hidden', step !== 3);
    
    // Update stepper UI
    for (let i = 1; i <= 3; i++) {
        const circle = document.getElementById('step-' + i + '-circle');
        const label = document.getElementById('step-' + i + '-label');
        const line = document.getElementById('line-' + i);
        
        if (i < step) {
            circle.className = 'w-12 h-12 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold transition-all';
            circle.innerHTML = '✓';
            label.className = 'text-xs font-bold mt-2 text-emerald-600';
            if (line) line.className = 'w-24 h-1 bg-emerald-500 mx-2 rounded transition-all';
        } else if (i === step) {
            circle.className = 'w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold shadow-lg ring-4 ring-blue-50 transition-all';
            circle.innerHTML = i;
            label.className = 'text-xs font-bold mt-2 text-blue-600';
        } else {
            circle.className = 'w-12 h-12 rounded-full bg-white text-slate-400 border-2 border-slate-200 flex items-center justify-center font-bold transition-all';
            circle.innerHTML = i;
            label.className = 'text-xs font-bold mt-2 text-slate-400';
            if (line) line.className = 'w-24 h-1 bg-slate-200 mx-2 rounded transition-all';
        }
    }
    
    currentStep = step;
    updateGrandTotal(); // Update total RAB jika di step 3
}

function nextStep() {
    if (currentStep < 3) {
        showStep(currentStep + 1);
    }
}

function prevStep() {
    if (currentStep > 1) {
        showStep(currentStep - 1);
    }
}

// Indikator Functions
function addIndikator() {
    const container = document.getElementById('indikatorContainer');
    const template = `
        <div class="indikator-row flex gap-3 items-start p-4 bg-slate-50 rounded-xl animate-fade-in">
            <div class="flex-1">
                <input type="text" name="indikator_keberhasilan[]"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm mb-2"
                       placeholder="Indikator Keberhasilan">
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="bulan_target[]"
                           class="px-3 py-2 border border-slate-300 rounded-lg text-sm"
                           placeholder="Bulan Target (cth: Januari 2025)">
                    <input type="number" name="bobot_persen[]"
                           class="px-3 py-2 border border-slate-300 rounded-lg text-sm"
                           placeholder="Bobot (%)" min="0" max="100" step="0.01">
                </div>
            </div>
            <button type="button" onclick="removeIndikator(this)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                <span class="material-icons text-sm">delete</span>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
}

function removeIndikator(btn) {
    const rows = document.querySelectorAll('.indikator-row');
    if (rows.length > 1) {
        btn.closest('.indikator-row').remove();
    } else {
        alert('Minimal harus ada 1 indikator kinerja!');
    }
}

// IKU Functions
function addIku() {
    const container = document.getElementById('ikuContainer');
    const template = `
        <div class="iku-row flex gap-3 items-center p-4 bg-slate-50 rounded-xl animate-fade-in">
            <div class="flex-1 grid grid-cols-2 gap-3">
                <select name="iku_ids[]" class="px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    <option value="">-- Pilih IKU --</option>
                    <?php foreach ($master_iku as $m): ?>
                        <option value="<?php echo $m['id']; ?>"><?php echo htmlspecialchars($m['deskripsi_iku']); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="iku_targets[]"
                       class="px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"
                       placeholder="Target Nilai/Capaian">
            </div>
            <button type="button" onclick="removeIku(this)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                <span class="material-icons text-sm">delete</span>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
}

function removeIku(btn) {
    const rows = document.querySelectorAll('.iku-row');
    if (rows.length > 1) {
        btn.closest('.iku-row').remove();
    } else {
        alert('Minimal harus ada 1 IKU!');
    }
}

// RAB Functions
function addRab() {
    const container = document.getElementById('rabContainer');
    const template = `
        <tr class="rab-row hover:bg-slate-50 animate-fade-in">
            <td class="px-3 py-2">
                <select name="rab_kategori[]" class="w-full px-2 py-2 border border-slate-300 rounded text-sm">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?php echo $k['id']; ?>"><?php echo htmlspecialchars($k['nama_kategori']); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td class="px-3 py-2">
                <input type="text" name="rab_uraian[]" class="w-full px-2 py-2 border border-slate-300 rounded text-sm" placeholder="Nama item...">
            </td>
            <td class="px-3 py-2">
                <input type="number" name="rab_volume[]" value="1" class="rab-volume w-full px-2 py-2 border border-slate-300 rounded text-sm text-center" min="1" onchange="hitungTotal(this)">
            </td>
            <td class="px-3 py-2">
                <select name="rab_satuan[]" class="w-full px-2 py-2 border border-slate-300 rounded text-sm">
                    <option value="unit">unit</option>
                    <option value="orang">orang</option>
                    <option value="paket">paket</option>
                    <option value="kegiatan">kegiatan</option>
                    <option value="jam">jam</option>
                    <option value="PP">PP</option>
                </select>
            </td>
            <td class="px-3 py-2">
                <input type="number" name="rab_harga[]" value="0" class="rab-harga w-full px-2 py-2 border border-slate-300 rounded text-sm text-right" min="0" onchange="hitungTotal(this)">
            </td>
            <td class="px-3 py-2 text-right font-bold text-slate-700 rab-total">
                Rp 0
            </td>
            <td class="px-3 py-2 text-center">
                <button type="button" onclick="removeRab(this)" class="p-1 text-red-600 hover:bg-red-50 rounded">
                    <span class="material-icons text-sm">delete</span>
                </button>
            </td>
        </tr>
    `;
    container.insertAdjacentHTML('beforeend', template);
}

function removeRab(btn) {
    const rows = document.querySelectorAll('.rab-row');
    if (rows.length > 1) {
        btn.closest('.rab-row').remove();
        updateGrandTotal();
    } else {
        alert('Minimal harus ada 1 item RAB!');
    }
}

function hitungTotal(input) {
    const row = input.closest('.rab-row');
    const volume = parseInt(row.querySelector('.rab-volume').value) || 0;
    const harga = parseInt(row.querySelector('.rab-harga').value) || 0;
    const total = volume * harga;
    
    row.querySelector('.rab-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    updateGrandTotal();
}

function updateGrandTotal() {
    let grandTotal = 0;
    document.querySelectorAll('.rab-row').forEach(row => {
        const volume = parseInt(row.querySelector('.rab-volume').value) || 0;
        const harga = parseInt(row.querySelector('.rab-harga').value) || 0;
        grandTotal += (volume * harga);
    });
    document.getElementById('grandTotal').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
}

// Save Draft (AJAX)
function saveDraft() {
    const formData = new FormData(document.getElementById('telaahForm'));
    
    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<span class="material-icons text-sm mr-2 animate-spin">refresh</span> Menyimpan...';
    
    fetch('/telaah/save-draft', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', 'Draft berhasil disimpan');
            // Update telaah_id untuk edit selanjutnya
            if (data.telaah_id) {
                document.getElementById('telaahId').value = data.telaah_id;
            }
        } else {
            showToast('error', data.message);
        }
    })
    .catch(error => {
        showToast('error', 'Terjadi kesalahan: ' + error.message);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<span class="material-icons text-sm mr-2">save</span> Simpan Draft';
    });
}

// Submit Telaah
function submitTelaah() {
    if (!confirm('Ajukan telaah ini ke Verifikator? Setelah diajukan, Anda tidak bisa mengedit lagi.')) {
        return;
    }
    
    const telaahId = document.getElementById('telaahId').value;
    if (!telaahId) {
        alert('Harap simpan draft terlebih dahulu!');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/telaah/submit';
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = 'csrf_token';
    csrfInput.value = '<?php echo $_SESSION['csrf_token']; ?>';
    form.appendChild(csrfInput);
    
    const idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'telaah_id';
    idInput.value = telaahId;
    form.appendChild(idInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Toast Notification
function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg animate-fade-in-down ${
        type === 'success' ? 'bg-emerald-600' : 'bg-rose-600'
    } text-white max-w-md`;
    toast.innerHTML = `
        <div class="flex items-start">
            <span class="material-icons mr-3">${type === 'success' ? 'check_circle' : 'error'}</span>
            <div>
                <div class="font-bold mb-1">${type === 'success' ? 'Berhasil!' : 'Error!'}</div>
                <div class="text-sm">${message}</div>
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.transition = 'all 0.5s ease-out';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-20px)';
        setTimeout(() => toast.remove(), 500);
    }, 4000);
}

// Initialize
showStep(1);
updateGrandTotal();
</script>
<?php include __DIR__.'/../partials/footer.php'; ?>
