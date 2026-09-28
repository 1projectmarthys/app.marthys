# Modul Internal Transfer

Extract zip ini ke folder `laravel9/`, timpa file yang sama.

## File

**Baru:**
```
database/migrations/2026_07_21_100000_create_internal_transfers_table.php
app/Models/InternalTransfer.php
app/Http/Controllers/InternalTransferController.php
resources/views/internal-transfer/index.blade.php
resources/views/internal-transfer/create.blade.php
resources/views/internal-transfer/edit.blade.php
resources/views/internal-transfer/show.blade.php
resources/views/internal-transfer/print.blade.php
```

**Diubah (timpa):**
```
routes/web.php                       (tambah route resource internal-transfer + print)
resources/views/layouts/app.blade.php (tambah menu sidebar "Internal Transfer")
```

## Setelah upload

```bash
php artisan migrate --path=database/migrations/2026_07_21_100000_create_internal_transfers_table.php
php artisan optimize:clear
```

## Ringkasan

- Menu **Internal Transfer** ada di sidebar seksi Accounting (di bawah Pembayaran Internal).
- Nomor dokumen otomatis: `002/MOI-FIT/VII/2026`, 3 digit, reset tiap bulan.
- **Terbilang** dihitung otomatis dari Jumlah Transfer (mis. 50.000.000 -> "Lima Puluh Juta Rupiah"),
  ada preview langsung saat mengetik di form.
- **Jenis Transfer**: pilih satu (Pemenuhan Saldo Operasional / Penempatan Deposito /
  Kebutuhan Payroll / Penarikan Kas Tunai / Lainnya + kolom teks).
- Print mengikuti contoh: FORM INTERNAL TRANSFER, meta (Nomor/Tanggal/Rencana Bayar),
  kotak Rekening Pengirim & Penerima, Jumlah + Terbilang, Jenis Transfer (checkbox),
  Note, dan tabel tanda tangan (Finance / Accounting / Manager FA / Wakil Direktur / Direktur Utama).

## Catatan

- Logo print memakai `asset('image/logo.png')` (sama dengan modul print lain). Kalau
  logo tidak muncul, otomatis diganti teks "marthys ORTHOPAEDICS".
- Hak akses menu mengikuti seksi Accounting (admin + accounting), sama seperti
  Pembayaran Internal. Kalau perlu role sendiri, beri tahu saya.
- Nomor `002` di contoh berarti dokumen kedua pada bulan itu; dokumen pertama yang
  Anda buat akan otomatis `001`.
