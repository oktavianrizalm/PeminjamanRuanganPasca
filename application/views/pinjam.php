<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman Ruangan</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 font-sans min-h-screen p-6 md:p-10 flex items-center justify-center">
    <div class="max-w-5xl w-full bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        
        <header class="flex flex-col items-center mb-8 border-b border-gray-100 pb-6">
            <img src="<?= base_url('logo-pln.png') ?>" alt="Logo PLN" class="h-16 w-auto mb-4" />
            <h1 class="text-2xl font-extrabold text-[#51156d] text-center">FORMULIR PEMINJAMAN RUANGAN</h1>
            <p class="text-gray-500 text-sm mt-1">Kampus Lebak Bulus</p>
        </header>

        <a href="<?= base_url('') ?>" class="inline-flex items-center text-[#8b36b4] hover:text-[#51156d] font-semibold mb-6 transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>

        <?php if($this->session->flashdata('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <p class="text-red-700 font-bold"><?= $this->session->flashdata('error') ?></p>
            </div>
        </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
            <p class="text-green-700 font-bold"><?= $this->session->flashdata('success') ?></p>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Form Section -->
            <div>
                <form method="POST" action="<?= base_url('pinjam') ?>" class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Ruangan</label>
                        <select name="nama_ruangan" id="ruangan_select" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#51156d] focus:border-[#51156d] outline-none transition-all bg-gray-50" required onchange="tampilkanJadwal()">
                            <option value="" disabled selected>Pilih Ruangan...</option>
                            <option value="R. LB 001">R. LB 001</option>
                            <option value="R. LB 002">R. LB 002</option>
                            <option value="R. LB 003">R. LB 003 (Ruang Rapat)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam" placeholder="Misal: BEM, Dosen, dll" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#51156d] focus:border-[#51156d] outline-none transition-all bg-gray-50" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" name="no_telp" placeholder="Misal: 08123456789" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#51156d] focus:border-[#51156d] outline-none transition-all bg-gray-50" required />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" placeholder="Misal: peminjam@gmail.com" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#51156d] focus:border-[#51156d] outline-none transition-all bg-gray-50" required />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kegiatan</label>
                        <input type="text" name="kegiatan" placeholder="Tujuan Peminjaman" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#51156d] focus:border-[#51156d] outline-none transition-all bg-gray-50" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pemakaian</label>
                        <input type="date" name="tanggal" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#51156d] focus:border-[#51156d] outline-none transition-all bg-gray-50" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#51156d] focus:border-[#51156d] outline-none transition-all bg-gray-50" required />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#51156d] focus:border-[#51156d] outline-none transition-all bg-gray-50" required />
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-8 bg-[#51156d] text-white font-bold py-4 rounded-xl shadow-lg hover:bg-[#3d0f52] hover:shadow-xl transition-all duration-200 text-lg">
                        Submit Permohonan
                    </button>
                </form>
            </div>

            <!-- Schedule Section -->
            <div id="jadwal_panel" class="bg-purple-50 rounded-xl p-6 border border-purple-100 hidden">
                <h3 class="text-lg font-bold text-[#51156d] mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Jadwal Terdaftar: <span id="nama_ruangan_label" class="ml-1 text-[#8b36b4]"></span>
                </h3>
                <div class="overflow-y-auto max-h-[400px] pr-2" id="jadwal_list">
                    <!-- Jadwal akan dimuat di sini via JS -->
                </div>
            </div>
        </div>
    </div>

    <script>
        const semuaJadwal = <?= json_encode($jadwal ?? []) ?>;

        function tampilkanJadwal() {
            const select = document.getElementById('ruangan_select');
            const ruangan = select.value;
            const panel = document.getElementById('jadwal_panel');
            const label = document.getElementById('nama_ruangan_label');
            const list = document.getElementById('jadwal_list');

            if (!ruangan) {
                panel.classList.add('hidden');
                return;
            }

            panel.classList.remove('hidden');
            label.innerText = ruangan;
            list.innerHTML = '';

            let searchNames = [ruangan];
            if (ruangan === "R. LB 001") searchNames = ["R. LB 001", "LB001"];
            else if (ruangan === "R. LB 002") searchNames = ["R. LB 002", "LB002"];
            else if (ruangan === "R. LB 003") searchNames = ["R. LB 003", "LB003", "Ruang Rapat"];

            const jadwalRuangan = semuaJadwal.filter(j => searchNames.includes(j.nama_ruangan));

            if (jadwalRuangan.length === 0) {
                list.innerHTML = '<div class="text-sm text-gray-500 italic py-4">Belum ada jadwal terdaftar untuk ruangan ini. Ruangan bebas digunakan.</div>';
                return;
            }

            const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
            jadwalRuangan.forEach(j => {
                const dateObj = new Date(j.tanggal);
                const dateStr = dateObj.toLocaleDateString('id-ID', options);
                const timeStart = j.waktu_mulai.substring(0, 5);
                const timeEnd = j.waktu_selesai.substring(0, 5);

                const item = `
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-3">
                        <div class="font-bold text-gray-800">${dateStr}</div>
                        <div class="text-sm text-[#8b36b4] font-semibold mt-1">${timeStart} - ${timeEnd}</div>
                        <div class="text-sm text-gray-600 mt-1">${j.kegiatan}</div>
                    </div>
                `;
                list.innerHTML += item;
            });
        }
    </script>
</body>
</html>
