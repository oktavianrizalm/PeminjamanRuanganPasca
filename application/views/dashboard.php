<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peminjaman Ruangan</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <?php
    date_default_timezone_set('Asia/Jakarta');
    function getDynamicStatus($status, $tanggal, $waktu_mulai, $waktu_selesai) {
        if ($status !== "Disetujui") return ['label' => $status, 'classes' => 'bg-gray-100 text-gray-700'];

        $now = date('Y-m-d H:i:s');
        $start = $tanggal . ' ' . $waktu_mulai;
        $end = $tanggal . ' ' . $waktu_selesai;

        if ($now < $start) {
            return ['label' => 'Akan Datang', 'classes' => 'bg-blue-100 text-blue-700'];
        } else if ($now >= $start && $now <= $end) {
            return ['label' => 'Sedang Berlangsung', 'classes' => 'bg-green-100 text-green-700 animate-pulse'];
        } else {
            return ['label' => 'Selesai', 'classes' => 'bg-gray-100 text-gray-500'];
        }
    }

    $jadwal_aktif = array_filter($jadwal, function($j) {
        $st = getDynamicStatus($j['status'], $j['tanggal'], $j['waktu_mulai'], $j['waktu_selesai']);
        return $st['label'] !== 'Selesai';
    });

    $lb001 = array_filter($jadwal_aktif, fn($j) => in_array($j['nama_ruangan'], ['R. LB 001', 'LB001']));
    $lb002 = array_filter($jadwal_aktif, fn($j) => in_array($j['nama_ruangan'], ['R. LB 002', 'LB002']));
    $lb003 = array_filter($jadwal_aktif, fn($j) => in_array($j['nama_ruangan'], ['R. LB 003', 'LB003', 'Ruang Rapat']));
    ?>

    <div class="min-h-screen p-6 md:p-10">
        <div class="max-w-7xl mx-auto space-y-10">
            <header class="flex flex-col md:flex-row md:items-center gap-6 border-b border-gray-200 pb-6">
                <img src="<?= base_url('logo-pln.png') ?>" alt="Logo Institut Teknologi PLN" class="h-16 md:h-20 w-auto object-contain" />
                <div class="md:border-l-2 md:border-gray-200 md:pl-6">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-[#51156d] tracking-tight">DASHBOARD PEMAKAIAN RUANGAN</h1>
                    <p class="text-[#8b36b4] font-medium mt-1">KAMPUS LEBAK BULUS</p>
                </div>
            </header>

            <div class="flex flex-col md:flex-row gap-6 items-start justify-between">
                <div class="flex flex-col gap-4 w-full md:w-auto">
                    <a href="<?= base_url('pinjam') ?>" class="group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white bg-[#51156d] rounded-xl shadow-lg hover:bg-[#3d0f52] hover:-translate-y-1 transition-all duration-200">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        KLIK DI SINI UNTUK PINJAM RUANGAN
                    </a>
                    <a href="<?= base_url('history') ?>" class="group relative inline-flex items-center justify-center px-8 py-3 font-semibold text-[#51156d] bg-purple-50 border-2 border-purple-200 rounded-xl hover:bg-purple-100 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Lihat History Ruangan
                    </a>
                </div>

                <div class="bg-amber-50 border-l-4 border-amber-500 p-5 rounded-r-xl shadow-sm md:max-w-md w-full">
                    <h3 class="font-bold text-amber-900 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        Perhatian Pengguna
                    </h3>
                    <ul class="text-sm text-amber-800 list-disc pl-5 space-y-1">
                        <li>Cek kekosongan jadwal pada tabel di bawah terlebih dahulu.</li>
                        <li>Isi formulir <strong>cukup 1x (satu kali)</strong> saja.</li>
                        <li>Tabel ter-update secara real-time / otomatis.</li>
                        <li>Apabila ada perubahan jadwal silahkan hubungi Rizal - Pascasarjana.</li>
                    </ul>
                </div>
            </div>

            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <h2 class="bg-[#51156d] text-white text-center py-3 font-bold text-lg">Semua Jadwal Terdaftar</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-purple-50/50 text-[#8b36b4]">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Ruangan</th>
                                <th class="px-6 py-4 font-semibold">Nama Peminjam</th>
                                <th class="px-6 py-4 font-semibold hidden admin-col">No. Telp</th>
                                <th class="px-6 py-4 font-semibold hidden admin-col">Email</th>
                                <th class="px-6 py-4 font-semibold">Kegiatan</th>
                                <th class="px-6 py-4 font-semibold">Tanggal</th>
                                <th class="px-6 py-4 font-semibold">Jam</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold hidden admin-col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($jadwal_aktif as $row): ?>
                                <?php $st = getDynamicStatus($row['status'], $row['tanggal'], $row['waktu_mulai'], $row['waktu_selesai']); ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-[#51156d]"><?= htmlspecialchars($row['nama_ruangan']) ?></td>
                                    <td class="px-6 py-4 text-gray-800"><?= htmlspecialchars($row['nama_peminjam']) ?></td>
                                    <td class="px-6 py-4 text-gray-600 hidden admin-col"><?= htmlspecialchars($row['no_telp'] ?? '') ?></td>
                                    <td class="px-6 py-4 text-gray-600 hidden admin-col"><?= htmlspecialchars($row['email'] ?? '') ?></td>
                                    <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($row['kegiatan']) ?></td>
                                    <td class="px-6 py-4 text-gray-600"><?= date('D, d M Y', strtotime($row['tanggal'])) ?></td>
                                    <td class="px-6 py-4 text-gray-800 font-medium">
                                        <?= substr($row['waktu_mulai'], 0, 5) ?> - <?= substr($row['waktu_selesai'], 0, 5) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold <?= $st['classes'] ?>"><?= $st['label'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 hidden admin-col">
                                        <div class="flex gap-2">
                                            <button onclick='openEditModal(<?= json_encode($row) ?>)' class="px-3 py-1 bg-amber-500 text-white rounded hover:bg-amber-600 text-xs font-bold shadow-sm">Edit</button>
                                            <button onclick='deleteJadwal(<?= $row['id'] ?>)' class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs font-bold shadow-sm">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($jadwal_aktif)): ?>
                                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada data peminjaman ruangan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-bold text-[#51156d] mb-6">DATA PEMAKAIAN PER RUANGAN</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php 
                    $rooms = ['R. LB 001' => $lb001, 'R. LB 002' => $lb002, 'R. LB 003' => $lb003];
                    foreach ($rooms as $roomName => $roomData): ?>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                            <div class="bg-[#51156d] text-white text-center py-3 font-bold text-lg"><?= $roomName ?></div>
                            <div class="p-0 overflow-y-auto max-h-80">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-purple-50/50 text-[#8b36b4] sticky top-0">
                                        <tr><th class="px-4 py-3 font-semibold">Tanggal & Jam</th><th class="px-4 py-3 font-semibold">Kegiatan</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <?php foreach ($roomData as $d): ?>
                                            <?php $st = getDynamicStatus($d['status'], $d['tanggal'], $d['waktu_mulai'], $d['waktu_selesai']); ?>
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3">
                                                    <div class="font-semibold text-gray-800"><?= date('D, d M Y', strtotime($d['tanggal'])) ?></div>
                                                    <div class="text-xs text-[#8b36b4] font-bold mt-0.5"><?= substr($d['waktu_mulai'], 0, 5) ?> - <?= substr($d['waktu_selesai'], 0, 5) ?></div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="text-gray-700 font-medium"><?= htmlspecialchars($d['kegiatan']) ?></div>
                                                    <div class="text-xs mt-1"><span class="px-2 py-0.5 font-bold rounded-full <?= $st['classes'] ?>"><?= $st['label'] ?></span></div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if(empty($roomData)): ?>
                                            <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400 text-xs">Kosong</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <footer class="pt-8 mt-8 border-t border-gray-200 text-center text-sm font-medium text-gray-500">
                🄯 MRO - Sekolah Pascasarjana & FF - BPTI- <button class="cursor-default" onclick="document.getElementById('authModal').classList.remove('hidden')">2025</button>
            </footer>
        </div>
    </div>

    <!-- Auth Modal -->
    <div id="authModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-xl shadow-xl max-w-sm w-full">
            <h3 class="text-lg font-bold mb-4 text-[#51156d]">Masukkan Kode Akses</h3>
            <input type="password" id="authCodeInput" class="w-full border border-gray-300 p-2 rounded mb-4 focus:ring-2 focus:ring-[#51156d] outline-none" placeholder="Kode Akses..." />
            <div class="flex justify-end gap-2">
                <button onclick="document.getElementById('authModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded font-medium hover:bg-gray-300">Batal</button>
                <button onclick="checkAuth()" class="px-4 py-2 bg-[#51156d] text-white rounded font-medium hover:bg-[#3d0f52]">Masuk</button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 hidden">
        <div class="bg-white p-6 rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-bold mb-4 text-[#51156d]">Edit Jadwal</h3>
            <form id="editForm" onsubmit="submitEdit(event)" class="space-y-4">
                <input type="hidden" name="id" id="edit_id" />
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Ruangan</label>
                    <select name="nama_ruangan" id="edit_nama_ruangan" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-[#51156d] outline-none">
                        <option value="R. LB 001">R. LB 001</option>
                        <option value="R. LB 002">R. LB 002</option>
                        <option value="R. LB 003">R. LB 003</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" id="edit_nama_peminjam" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-[#51156d] outline-none" required />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Nomor Telepon</label>
                        <input type="tel" name="no_telp" id="edit_no_telp" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-[#51156d] outline-none" required />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Email</label>
                        <input type="email" name="email" id="edit_email" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-[#51156d] outline-none" required />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Kegiatan</label>
                    <input type="text" name="kegiatan" id="edit_kegiatan" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-[#51156d] outline-none" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" id="edit_tanggal" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-[#51156d] outline-none" required />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" id="edit_waktu_mulai" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-[#51156d] outline-none" required />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Waktu Selesai</label>
                        <input type="time" name="waktu_selesai" id="edit_waktu_selesai" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-[#51156d] outline-none" required />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded font-medium hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#51156d] text-white rounded font-medium hover:bg-[#3d0f52]">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentAuthCode = '';

        function checkAuth() {
            const code = document.getElementById('authCodeInput').value;
            if (code === '@Lebak123') {
                currentAuthCode = code;
                document.getElementById('authModal').classList.add('hidden');
                document.getElementById('authCodeInput').value = '';
                // Tampilkan kolom admin
                document.querySelectorAll('.admin-col').forEach(el => el.classList.remove('hidden'));
            } else {
                alert('Kode akses salah!');
            }
        }

        function openEditModal(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_nama_ruangan').value = data.nama_ruangan;
            document.getElementById('edit_nama_peminjam').value = data.nama_peminjam;
            document.getElementById('edit_no_telp').value = data.no_telp || '';
            document.getElementById('edit_email').value = data.email || '';
            document.getElementById('edit_kegiatan').value = data.kegiatan;
            document.getElementById('edit_tanggal').value = data.tanggal.split(' ')[0];
            document.getElementById('edit_waktu_mulai').value = data.waktu_mulai;
            document.getElementById('edit_waktu_selesai').value = data.waktu_selesai;
            document.getElementById('editModal').classList.remove('hidden');
        }

        async function submitEdit(e) {
            e.preventDefault();
            const formData = new FormData(document.getElementById('editForm'));
            formData.append('auth_code', currentAuthCode);

            const res = await fetch('<?= base_url('peminjaman/edit') ?>', { method: 'POST', body: formData });
            const result = await res.json();
            if (result.success) {
                location.reload();
            } else {
                alert(result.error || 'Terjadi kesalahan');
            }
        }

        async function deleteJadwal(id) {
            if (!confirm('Yakin ingin menghapus jadwal ini?')) return;
            const formData = new FormData();
            formData.append('id', id);
            formData.append('auth_code', currentAuthCode);

            const res = await fetch('<?= base_url('peminjaman/delete') ?>', { method: 'POST', body: formData });
            const result = await res.json();
            if (result.success) {
                location.reload();
            } else {
                alert(result.error || 'Terjadi kesalahan');
            }
        }
    </script>
</body>
</html>
