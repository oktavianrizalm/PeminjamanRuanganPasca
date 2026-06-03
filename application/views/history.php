<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Peminjaman</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="bg-white min-h-screen p-6 md:p-10 font-sans">
    <?php
    date_default_timezone_set('Asia/Jakarta');
    function getDynamicStatus($status, $tanggal, $waktu_mulai, $waktu_selesai) {
        if ($status !== "Disetujui") return $status;
        $now = date('Y-m-d H:i:s');
        $start = $tanggal . ' ' . $waktu_mulai;
        $end = $tanggal . ' ' . $waktu_selesai;

        if ($now < $start) return "Akan Datang";
        if ($now >= $start && $now <= $end) return "Sedang Berlangsung";
        return "Selesai";
    }

    // Pagination Logic
    $itemsPerPage = 50;
    $totalItems = count($history);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $totalPages = $totalPages > 0 ? $totalPages : 1;
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($currentPage < 1) $currentPage = 1;
    if ($currentPage > $totalPages) $currentPage = $totalPages;

    $offset = ($currentPage - 1) * $itemsPerPage;
    $paginatedHistory = array_slice($history, $offset, $itemsPerPage);
    ?>

    <div class="max-w-7xl mx-auto space-y-10">
        <header class="flex flex-col md:flex-row md:items-center gap-6 pb-2">
            <img src="<?= base_url('logo-pln.png') ?>" alt="Logo Institut Teknologi PLN" class="h-16 md:h-20 w-auto object-contain" />
            <div class="md:pl-2">
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight">HISTORY PEMAKAIAN RUANGAN LEBAK BULUS</h1>
            </div>
        </header>

        <div>
            <a href="<?= base_url('') ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="overflow-x-auto shadow-sm">
            <table class="w-full text-left text-sm whitespace-nowrap border-collapse">
                <thead class="bg-[#1873cc] text-white">
                    <tr>
                        <th class="px-4 py-3 font-bold border-r border-blue-500 w-10 text-center">No.</th>
                        <th class="px-4 py-3 font-bold border-r border-blue-500">Nama Ruangan</th>
                        <th class="px-4 py-3 font-bold border-r border-blue-500">Nama Peminjam</th>
                        <th class="px-4 py-3 font-bold border-r border-blue-500">Kegiatan</th>
                        <th class="px-4 py-3 font-bold border-r border-blue-500">Tanggal</th>
                        <th class="px-4 py-3 font-bold border-r border-blue-500">Waktu Mulai</th>
                        <th class="px-4 py-3 font-bold border-r border-blue-500">Waktu Selesai</th>
                        <th class="px-4 py-3 font-bold">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-100">
                    <?php foreach($paginatedHistory as $index => $row): ?>
                    <tr class="odd:bg-gray-500 even:bg-gray-600 hover:opacity-90 transition-opacity">
                        <td class="px-4 py-3 border-r border-gray-400/30 text-center"><?= $offset + $index + 1 ?>.</td>
                        <td class="px-4 py-3 border-r border-gray-400/30"><?= str_replace('R. ', '', $row['nama_ruangan']) ?></td>
                        <td class="px-4 py-3 border-r border-gray-400/30"><?= htmlspecialchars($row['nama_peminjam']) ?></td>
                        <td class="px-4 py-3 border-r border-gray-400/30"><?= htmlspecialchars($row['kegiatan']) ?></td>
                        <td class="px-4 py-3 border-r border-gray-400/30"><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                        <td class="px-4 py-3 border-r border-gray-400/30"><?= ltrim(substr($row['waktu_mulai'], 0, 5), '0') ?></td>
                        <td class="px-4 py-3 border-r border-gray-400/30"><?= ltrim(substr($row['waktu_selesai'], 0, 5), '0') ?></td>
                        <td class="px-4 py-3"><?= getDynamicStatus($row['status'], $row['tanggal'], $row['waktu_mulai'], $row['waktu_selesai']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($paginatedHistory)): ?>
                    <tr><td colspan="8" class="px-6 py-12 text-center text-gray-500 bg-gray-100">Belum ada riwayat peminjaman ruangan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($totalPages > 1): ?>
        <div class="flex justify-between items-center mt-6">
            <div class="text-sm text-gray-600 font-medium">
                Menampilkan <?= $offset + 1 ?> hingga <?= min($currentPage * $itemsPerPage, $totalItems) ?> dari <?= $totalItems ?> data
            </div>
            <div class="flex gap-2">
                <a href="<?= $currentPage > 1 ? '?page='.($currentPage-1) : '#' ?>" class="px-4 py-2 border rounded font-medium text-gray-700 bg-white hover:bg-gray-50 <?= $currentPage == 1 ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' ?>">Sebelumnya</a>
                <div class="px-4 py-2 text-gray-700 font-semibold border rounded bg-gray-50">
                    Halaman <?= $currentPage ?> dari <?= $totalPages ?>
                </div>
                <a href="<?= $currentPage < $totalPages ? '?page='.($currentPage+1) : '#' ?>" class="px-4 py-2 border rounded font-medium text-gray-700 bg-white hover:bg-gray-50 <?= $currentPage == $totalPages ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' ?>">Selanjutnya</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
