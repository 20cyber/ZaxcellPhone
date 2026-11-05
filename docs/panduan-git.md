# Panduan Git untuk Kelompok

## Pertama kali
```bash
git clone https://github.com/20cyber/ZaxcellPhone.git
cd ZaxcellPhone
composer install
copy .env.example .env
php artisan key:generate
```

Lalu edit `.env`, sesuaikan `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` dengan setup MySQL lokal kamu
(biasanya `DB_USERNAME=root`, `DB_PASSWORD=` kosong kalau pakai Laragon default).

### Isi database (pilih salah satu)
**Opsi A — pakai dump database (paling gampang, dapat data yang sama persis):**
1. Buat database kosong namanya `zaxcellphone` lewat phpMyAdmin
2. Klik database itu → tab **Import** → pilih file `database/dump/zaxcellphone.sql` dari hasil clone → klik **Go**
3. Selesai, data sama persis kayak yang dipakai buat demo

**Opsi B — generate data baru lewat migrasi (data acak, bukan yang asli):**
```bash
php artisan migrate --seed
```

### Jalankan server
```bash
php artisan serve
```
Buka `http://127.0.0.1:8000`. Login admin: `admin@zaxcellphone.test` / `password`.

## Alur kerja harian
```bash
git checkout main
git pull origin main                 # ambil update terbaru
git checkout -b fitur/nama-fitur     # buat branch baru
# ... ngoding ...
git add .
git commit -m "tambah halaman keranjang"
git push origin fitur/nama-fitur
```
Lalu buka GitHub dan buat **Pull Request** ke `main`. Minta minimal 1 teman mengecek sebelum di-merge.

## Aturan penting
- Jangan kerja langsung di `main`.
- Pesan commit singkat dan jelas.
- Sebelum mulai kerja, selalu `git pull origin main`.
- Jangan upload `.env` atau key rahasia. Kirim lewat chat pribadi.
- Kalau ada konflik, jangan panik: tanya di grup.
