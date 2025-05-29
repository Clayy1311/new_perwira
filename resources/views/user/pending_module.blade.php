<h3 class="text-xl font-semibold mb-3">Modul Menunggu Persetujuan</h3>
<div class="bg-yellow-50 border border-yellow-400 p-4 rounded">
    <p>Nama Modul: <strong>{{ $pendingModule->module?->name ?? 'Modul Tidak Ditemukan' }}</strong></p>
    <p>Jenis Durasi: <strong>{{ $pendingModule->module_type === 'lifetime' ? 'Lifetime' : '1 Tahun' }}</strong></p>
    <p>Tanggal Dipilih: <strong>{{ $pendingModule->created_at->format('d M Y H:i') }}</strong></p>
    <p>Status Persetujuan: <strong>Menunggu Persetujuan</strong></p>
    <p class="mt-2 text-sm text-gray-600">Mohon tunggu notifikasi dari kami setelah modul disetujui.</p>
</div>
