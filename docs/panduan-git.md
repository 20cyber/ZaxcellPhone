# Panduan Git untuk Kelompok

## Pertama kali
```bash
git clone https://github.com/USERNAME/zaxcellphone.git
cd zaxcellphone
```

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
