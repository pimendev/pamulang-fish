# 🐟 Pamulang Betta Store — Sistem E-Commerce Spesialis Ikan Cupang Hias

> **Toko Online 100% Eksklusif Ikan Cupang Hias (Betta Fish)**  
> Implementasi Kurikulum Lengkap: **Pertemuan 5 s/d Pertemuan 12 (UAS Final Milestone)**

---

## 📌 Ringkasan Proyek

**Pamulang Betta Store** adalah platform e-commerce live animal e-commerce yang dirancang khusus untuk ekosistem ikan cupang hias (tanpa spesies ikan lain). Platform ini dilengkapi sistem penanganan spesimen hidup (Live Animal Handling), jaminan keselamatan sampai tujuan (*Death on Arrival Guarantee*), pelacakan tahapan karantina & packing oksigen, live appearance customizer, CMS edukasi rawat cupang, serta analitik omzet admin.

---

## 🚀 Rangkuman Capaian Tiap Pertemuan (5 s/d 12)

| Pertemuan | Fokus Pembelajaran & Fitur | Status |
|:---:|:---|:---:|
| **Pertemuan 5** | **Fondasi, Identitas Brand & Multi-Auth**<br>• Eksklusivitas 100% Ikan Cupang Hias.<br>• Sistem Multi-Role Auth (Admin & Customer) via Middleware `EnsureUserIsAdmin`.<br>• Database Schema MySQL Laragon (Port 3307): `users`, `categories`, `products`, `orders`, `order_items`, `reviews`, `articles`, `settings`.<br>• Design System & Appearance Tokens dinamis (Primary, Accent, Font, Radius, Dark/Light Mode). | **Selesai 100%** |
| **Pertemuan 6** | **Live Appearance Customizer & CRUD Spesimen WYSIWYG**<br>• Dashboard Live Appearance Customizer dengan interactive real-time preview browser.<br>• CRUD Kategori Varietas Cupang (Halfmoon, Plakat, Crowntail, Giant, Double Tail).<br>• CRUD Manajemen Spesimen Cupang (1-Ikan-1-Stok WYSIWYG) dengan form upload foto, form morfologi, dan fitur duplikasi spesimen. | **Selesai 100%** |
| **Pertemuan 7** | **Katalog Filter Multi-Faceted & Soliter Showcase**<br>• Filter katalog: Varietas, Gender (Jantan/Betina), Grade (Top Grade, Avatar, Nemo, dll.), Rentang Harga, dan Urutan.<br>• Soliter Showcase (Product Detail): Gallery foto, visual badge "Spesimen Unik WYSIWYG", Spec Sheet Morfologi & Parameter Air (pH 6.5–7.2, Suhu 26–29°C), serta Care Guide.<br>• Shopping Cart: Keranjang belanja interaktif dengan proteksi stok spesimen unik dan penghitungan biaya packing oksigen & sterofoam otomatis. | **Selesai 100%** |
| **Pertemuan 8 (UTS)** | **Live Animal Checkout & Payment Simulation**<br>• Live Animal Checkout dengan verifikasi alamat lengkap & nomor WhatsApp.<br>• Ekspedisi Kilat Khusus Hewan Hidup (JNE YES & TIKI ONS) + Safety Packing Sterofoam & Tabung Oksigen.<br>• Jaminan Death on Arrival (D.O.A) via persetujuan checkbox wajib video unboxing tanpa cut.<br>• Simulasi Payment Gateway: Transfer Manual (BCA & Mandiri) dan Instant QRIS dengan fitur unggah bukti transfer. | **Selesai 100%** |
| **Pertemuan 9** | **CMS Edukasi Tips Cupang & Sistem Wishlist**<br>• Modul Edukasi & Blog Perawatan Ikan Cupang (panduan pakan jentik, kutu air, pencegahan dropsy/fin rot).<br>• Cross-selling dinamis: Menampilkan spesimen cupang terkait langsung di bawah artikel panduan.<br>• Sistem Wishlist: Customer dapat menyimpan spesimen cupang favorit ke dalam wishlist pribadi. | **Selesai 100%** |
| **Pertemuan 10** | **Live Tracking Ekspedisi Ikan Hidup & Review**<br>• Stepper Pelacakan 6 Tahap Khusus Ikan Hidup: *Pesanan Dibuat ➔ Karantina & Puasa 24 Jam ➔ Packing Oksigen & Sterofoam ➔ Diserahkan ke Ekspedisi Kilat ➔ Ikan Sedang Meluncur ➔ Tiba di Soliter Pembeli*.<br>• Tracking Publik tanpa login melalui Nomor Resi / Order Code.<br>• Integrasi tombol WhatsApp Customer Care (`wa.me`) dengan format pesan pesanan otomatis.<br>• Sistem Rating & Ulasan Spesimen (Bintang 1–5 & testimoni kondisi ikan hidup). | **Selesai 100%** |
| **Pertemuan 11** | **Manajemen Pesanan Admin & Analitik Omzet**<br>• Manajemen Order Admin: Update tahapan pengiriman 6 langkah dan input nomor resi ekspedisi.<br>• Dashboard Analitik: Total omzet (Rp), grafik status pesanan, dan rekap performa varietas cupang terlaris.<br>• Ekspor Laporan: Download data penjualan format Excel (.csv) dan Halaman Cetak PDF (*Print-ready CSS*) untuk pembukuan fisik. | **Selesai 100%** |
| **Pertemuan 12 (UAS)** | **Automated Testing Suite, Code Formatting & Finalisasi Dokumen**<br>• PHPUnit Automated Test Suite: 20 Test Cases (109 assertions) 100% lulus tanpa kegagalan.<br>• Laravel Pint: Standarisasi PSR-12 dan Laravel styling.<br>• Dokumen Resmi Word: `ROADMAP_PENGERJAAN_PAMULANG_FISH_PERTEMUAN_5_12.docx` ter-generate otomatis dengan status 100% Selesai. | **Selesai 100%** |

---

## 🔑 Kredensial Akun Default

Sistem telah dilengkapi data seeder lengkap untuk pengujian langsung:

| Tipe Akun | Email | Password | Hak Akses |
|:---|:---|:---|:---|
| **Super Admin** | `admin@pamulangfish.com` | `password` | Akses penuh: `/admin` (Katalog, Pesanan, Laporan, Edukasi, Appearance) |
| **Customer Demo** | `customer@pamulangfish.com` | `password` | Akses publik: Belanja, Cart, Checkout, Wishlist, Order Tracking, Review |

---

## 🛠️ Persyaratan Lingkungan (Environment)

- **PHP**: `^8.2` atau `8.3` (Di Laragon: `C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe`)
- **Composer**: `^2.x`
- **Database**: MySQL 8.0 / MariaDB (Port: `3307`, Database: `ikan_cupang`)
- **Web Server**: Apache / Nginx bawaan Laragon

---

## ⚙️ Panduan Menjalankan Aplikasi

1. **Jalankan Laragon**  
   Buka aplikasi Laragon, pastikan Apache dan MySQL (Port 3307) aktif (`Start All`).

2. **Migrasi dan Seeder (Jika diperlukan reset database)**:
   ```bash
   php artisan migrate:fresh --seed
   ```

3. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser pada `http://127.0.0.1:8000` atau virtual host Laragon `http://ikan-cupang.test`.

4. **Kompilasi Frontend (Jika mengedit styling Blade)**:
   ```bash
   npm run build
   # atau untuk mode live watch:
   npm run dev
   ```

---

## 🧪 Pengujian Otomatis (Automated Testing)

Proyek ini telah dilengkapi dengan rangkaian Feature Test komprehensif menggunakan PHPUnit:

```bash
# Menjalankan seluruh test suite (PHP 8.3)
vendor/bin/phpunit
```

### Hasil Test Suite Saat Ini:
```
OK (20 tests, 147 assertions)
- Tests\Feature\AuthTest: Registrasi, Login, Autentikasi Pengguna
- Tests\Feature\CatalogAndCartTest: Filter Katalog, Soliter Showcase, Cart WYSIWYG
- Tests\Feature\CheckoutAndOrderTest: Checkout Hewan Hidup, D.O.A, Bukti Bayar, Tracking Resi
- Tests\Feature\ArticleAndWishlistTest: CMS Edukasi, Toggle Wishlist, Rating & Review
- Tests\Feature\AdminManagementTest: Akses Role Admin, CRUD Varietas & Ikan, Update Resi, Laporan CSV/Print
```

### Format Kode (Laravel Pint):
```bash
vendor/bin/pint --format agent
```

---

## 📁 Struktur Dokumen Pendukung

- **Dokumen Roadmap Word UAS**:  
  [`ROADMAP_PENGERJAAN_PAMULANG_FISH_PERTEMUAN_5_12.docx`](./ROADMAP_PENGERJAAN_PAMULANG_FISH_PERTEMUAN_5_12.docx)  
  *(Dibuat secara otomatis dengan tabel progress, penjelasan teknis, dan verifikasi milestone 5–12)*.
- **Skrip Pembuat Dokumen**:  
  [`build_roadmap_docx.py`](./build_roadmap_docx.py)

---

## 🏆 Fitur Unggulan Sistem

1. **Aturan WYSIWYG (What You See Is What You Get) 1-Ikan-1-Stok**:
   Setiap ikan cupang adalah spesimen hidup yang unik dengan foto asli masing-masing, sistem secara otomatis mengunci stok maksimal 1 per varian.
2. **Jaminan Keselamatan D.O.A (Death On Arrival)**:
   Fitur proteksi garansi hidup dengan regulasi video unboxing tanpa terputus dan pemilihan wajib ekspedisi kilat (JNE YES / TIKI ONS).
3. **Live Animal Tracking Stepper**:
   Pelacakan real-time berstandar karantina ikan hias yang transparan bagi pembeli dan kurir.
4. **Live Appearance Customizer**:
   Admin dapat menyesuaikan tema warna, font family, border radius, serta mode tampilan toko secara langsung dari antarmuka web.
5. **CMS Edukasi & Cross-Selling**:
   Artikel panduan perawatan cupang yang otomatis mengaitkan produk spesimen rekomendasi di bawah bacaan.
6. **Ekspor Laporan & Cetak Pembukuan**:
   Ekspor data penjualan ke file CSV (Excel-ready) dan tata letak print invoice/laporan siap cetak.
