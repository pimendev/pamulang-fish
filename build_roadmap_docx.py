import os
from docx import Document
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT, WD_ALIGN_VERTICAL
from docx.oxml import OxmlElement, parse_xml
from docx.oxml.ns import nsdecls, qn

def set_cell_background(cell, fill_hex):
    shading_xml = f'<w:shd {nsdecls("w")} w:fill="{fill_hex}"/>'
    cell._tc.get_or_add_tcPr().append(parse_xml(shading_xml))

def set_cell_margins(cell, top=140, bottom=140, left=180, right=180):
    tcPr = cell._tc.get_or_add_tcPr()
    tcMar = OxmlElement('w:tcMar')
    for m, val in [('w:top', top), ('w:bottom', bottom), ('w:left', left), ('w:right', right)]:
        node = OxmlElement(m)
        node.set(qn('w:w'), str(val))
        node.set(qn('w:type'), 'dxa')
        tcMar.append(node)
    tcPr.append(tcMar)

def style_heading(p, text, font_size=14, bold=True, color_rgb=(2, 132, 199)):
    p.paragraph_format.space_before = Pt(14)
    p.paragraph_format.space_after = Pt(6)
    p.paragraph_format.keep_with_next = True
    run = p.add_run(text)
    run.font.name = 'Arial'
    run.font.size = Pt(font_size)
    run.font.bold = bold
    run.font.color.rgb = RGBColor(*color_rgb)
    return run

def create_document():
    doc = Document()
    
    # Page setup - Margins 1 inch
    for section in doc.sections:
        section.top_margin = Inches(0.8)
        section.bottom_margin = Inches(0.8)
        section.left_margin = Inches(0.8)
        section.right_margin = Inches(0.8)

    # Document Header / Title
    title_p = doc.add_paragraph()
    title_p.paragraph_format.space_before = Pt(0)
    title_p.paragraph_format.space_after = Pt(2)
    title_p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    r_title = title_p.add_run("ROADMAP PENGERJAAN PROYEK WEB")
    r_title.font.name = 'Arial'
    r_title.font.size = Pt(20)
    r_title.font.bold = True
    r_title.font.color.rgb = RGBColor(15, 23, 42)

    sub_p = doc.add_paragraph()
    sub_p.paragraph_format.space_after = Pt(14)
    sub_p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    r_sub = sub_p.add_run("PAMULANG FISH STORE — TOKO ONLINE 100% KHUSUS IKAN CUPANG HIAS\n(BETTA FISH ONLY — PERTEMUAN 5 SAMPAI PERTEMUAN 12)")
    r_sub.font.name = 'Arial'
    r_sub.font.size = Pt(12)
    r_sub.font.bold = True
    r_sub.font.color.rgb = RGBColor(2, 132, 199)

    # Info Box Table
    info_table = doc.add_table(rows=5, cols=2)
    info_table.alignment = WD_TABLE_ALIGNMENT.CENTER
    info_data = [
        ("Nama Aplikasi / Toko", "Pamulang Fish Store (E-Commerce Khusus Ikan Cupang Hias)"),
        ("Spesifikasi Produk", "100% Khusus Ikan Cupang (Betta Fish Only — Tanpa Ikan Jenis Lain)"),
        ("Teknologi Framework", "Laravel 13 (PHP 8.3) + Tailwind CSS + MySQL 8.0 (Port 3307)"),
        ("Akun Super Admin", "Email: admin@pamulangfish.com | Password: password"),
        ("Akun Customer Demo", "Email: customer@pamulangfish.com | Password: password"),
    ]
    for row_idx, (k, v) in enumerate(info_data):
        row = info_table.rows[row_idx]
        cell_k, cell_v = row.cells[0], row.cells[1]
        cell_k.width = Inches(2.2)
        cell_v.width = Inches(4.8)
        set_cell_background(cell_k, "F1F5F9")
        set_cell_background(cell_v, "FFFFFF" if row_idx % 2 == 0 else "F8FAFC")
        set_cell_margins(cell_k, top=100, bottom=100, left=140, right=140)
        set_cell_margins(cell_v, top=100, bottom=100, left=140, right=140)
        
        pk = cell_k.paragraphs[0]
        pk.paragraph_format.space_after = Pt(0)
        rk = pk.add_run(k)
        rk.font.name = 'Arial'
        rk.font.size = Pt(10)
        rk.font.bold = True
        rk.font.color.rgb = RGBColor(30, 41, 59)

        pv = cell_v.paragraphs[0]
        pv.paragraph_format.space_after = Pt(0)
        rv = pv.add_run(v)
        rv.font.name = 'Arial'
        rv.font.size = Pt(10)
        if "admin@pamulangfish.com" in v:
            rv.font.bold = True
            rv.font.color.rgb = RGBColor(2, 132, 199)
        elif "100% Khusus" in v:
            rv.font.bold = True
            rv.font.color.rgb = RGBColor(5, 150, 105)
        else:
            rv.font.color.rgb = RGBColor(51, 65, 85)

    doc.add_paragraph().paragraph_format.space_after = Pt(8)

    # 1. Pernyataan Khusus Ikan Cupang
    style_heading(doc.add_paragraph(), "1. KETENTUAN KATALOG: 100% KHUSUS IKAN CUPANG (BETTA FISH)", 13, True, (15, 23, 42))
    p_cupang = doc.add_paragraph()
    p_cupang.paragraph_format.space_after = Pt(6)
    r_cp = p_cupang.add_run(
        "Sesuai instruksi mutlak, toko Pamulang Fish Store adalah platform yang 100% KHUSUS menjual ikan cupang hias (Betta Fish) "
        "dan jenis-jenis variasi ikan cupang. Toko ini TIDAK menjual ikan hias jenis lain di luar ikan cupang (tidak ada guppy, koki, "
        "koi biasa, arwana, louhan, dll). Seluruh kategori dan produk wajib berupa spesimen dan jenis-jenis ikan cupang kontes."
    )
    r_cp.font.name = 'Arial'
    r_cp.font.size = Pt(10)
    r_cp.font.color.rgb = RGBColor(51, 65, 85)

    # Tabel 8 Kategori Jenis Ikan Cupang
    doc.add_paragraph().paragraph_format.space_after = Pt(2)
    style_heading(doc.add_paragraph(), "Daftar 8 Kategori Varietas Ikan Cupang di Pamulang Fish Store:", 11, True, (2, 132, 199))
    cat_table = doc.add_table(rows=9, cols=3)
    cat_table.alignment = WD_TABLE_ALIGNMENT.CENTER
    cat_headers = ["No", "Nama Jenis / Varietas Cupang", "Karakteristik Utama"]
    for c_idx, h in enumerate(cat_headers):
        cell = cat_table.rows[0].cells[c_idx]
        set_cell_background(cell, "0284C7")
        set_cell_margins(cell, top=120, bottom=120, left=120, right=120)
        p = cell.paragraphs[0]
        p.paragraph_format.space_after = Pt(0)
        r = p.add_run(h)
        r.font.name = 'Arial'
        r.font.size = Pt(10)
        r.font.bold = True
        r.font.color.rgb = RGBColor(255, 255, 255)

    categories_list = [
        ("1", "Cupang Halfmoon (HM)", "Bukaan sirip dan ekor 180° membentuk setengah lingkaran sempurna yang anggun."),
        ("2", "Cupang Plakat (PK)", "Ekor pendek petarung yang lincah, berotot, daya tahan tinggi, dan corak mutasi beragam."),
        ("3", "Cupang Crowntail / Serit (CT)", "Karya breeder asli Indonesia dengan sirip menyerupai mahkota berduri menjuntai artistik."),
        ("4", "Cupang Koi & Nemo Galaxy", "Mutasi corak warna marble menyerupai ikan koi Jepang dipadu taburan sisik bintang galaksi."),
        ("5", "Cupang Giant (Raksasa)", "Postur tubuh jumbo berukuran Body Only (BO) mencapai 6.0 hingga 7.5 cm."),
        ("6", "Cupang Double Tail / Cagak (DT)", "Ekor bercabang dua simetris dengan sirip punggung (dorsal) ekstra lebar."),
        ("7", "Cupang Dumbo Ear (Big Ear)", "Sirip dayung samping putih lebar menyerupai telinga gajah yang anggun mengembang."),
        ("8", "Cupang Alien & Wild Betta", "Hibrida cupang alam liar (Mahachai x Smaragdina) dengan kilau sisik hijau/biru metalik."),
    ]
    for row_idx, data in enumerate(categories_list, start=1):
        row = cat_table.rows[row_idx]
        for col_idx, text in enumerate(data):
            cell = row.cells[col_idx]
            if col_idx == 0:
                cell.width = Inches(0.5)
            elif col_idx == 1:
                cell.width = Inches(2.3)
            else:
                cell.width = Inches(4.2)
            bg = "FFFFFF" if row_idx % 2 == 1 else "F8FAFC"
            set_cell_background(cell, bg)
            set_cell_margins(cell, top=80, bottom=80, left=100, right=100)
            p = cell.paragraphs[0]
            p.paragraph_format.space_after = Pt(0)
            r = p.add_run(text)
            r.font.name = 'Arial'
            r.font.size = Pt(9.5)
            if col_idx == 1:
                r.font.bold = True
                r.font.color.rgb = RGBColor(15, 23, 42)
            else:
                r.font.color.rgb = RGBColor(51, 65, 85)

    doc.add_paragraph().paragraph_format.space_after = Pt(10)

    # 2. Rincian Pengerjaan Pertemuan 5 - 12
    style_heading(doc.add_paragraph(), "2. DETAIL BREAKDOWN PENGERJAAN (PERTEMUAN 5 SAMPAI 12)", 13, True, (15, 23, 42))
    
    weeks = [
        ("Pertemuan 5 (Minggu 1) — Pondasi Framework & Brand Identity", "STATUS: SELESAI (100% COMPLETE)", [
            "Instalasi Laravel 13.34.0 & PHP 8.3 di folder c:\\laragon\\www\\ikan cupang.",
            "Konfigurasi database MySQL 8.0 pada Port 3307 (database: ikan_cupang).",
            "Penerapan identitas toko: Pamulang Fish Store (100% Khusus Ikan Cupang Hias).",
            "Desain Dynamic Appearance Engine (6 Design Tokens: warna tema, font Plus Jakarta Sans, border-radius).",
            "Pembuatan Multi-Auth (Super Admin, Admin, Customer) dan Middleware EnsureUserIsAdmin.",
            "Pembuatan Seeder 8 Kategori Khusus Ikan Cupang dan 12 Produk Spesimen Ikan Cupang Pilihan.",
            "Manajemen Foto: Dukungan placeholder modern yang rapi serta upload foto spesimen asli.",
            "Pembuatan Akun Admin (admin@pamulangfish.com / password) & Customer (customer@pamulangfish.com / password).",
            "Implementasi Landing Page Frontend & Dashboard Admin Overview.",
            "Pengujian Otomatis Feature Tests PHPUnit."
        ], "059669"),
        ("Pertemuan 6 (Minggu 2) — Live Appearance Editor & Manajemen Spesimen Cupang", "STATUS: SELESAI (100% COMPLETE)", [
            "Panel Admin Live Appearance Customizer (/admin/appearance): Color Pickers, Font Selector, Border Radius, Theme Mode, Button/Navbar Style dengan sinkronisasi real-time preview tanpa reload.",
            "CRUD Manajemen Ikan Cupang (/admin/products): Form input spesimen lengkap, upload foto, status available/sold/reserved/coming_soon, dan tombol duplikasi instan.",
            "Atribut morfologi spesifik cupang: Betta Type, Gender (Jantan/Betina/Pair), Ukuran Badan/BO (cm), Umur (bulan), Pola Warna, Tingkat Perawatan, Care Guide.",
            "CRUD Manajemen Kategori Varietas Cupang (/admin/categories): Halfmoon, Plakat, Crowntail, Giant, Double Tail, dll."
        ], "059669"),
        ("Pertemuan 7 (Minggu 3) — Katalog Filter Cupang, Soliter Showcase & Keranjang Belanja", "STATUS: SELESAI (100% COMPLETE)", [
            "Katalog frontend (/catalog) dengan filter multi-faceted: pencarian kata kunci, kategori varietas, tipe sirip, gender, tingkat perawatan, rentang harga, dan sorting dinamis.",
            "Halaman detail produk (*Soliter Showcase* di /cupang/{slug}): Galeri foto resolusi tinggi, tabel spesifikasi morfologi lengkap, panduan parameter air soliter, dan badge jaminan D.O.A.",
            "Fitur Keranjang Belanja (/cart): Session-based shopping cart dengan validasi stok 1-ikan-1-stok (WYSIWYG), kontrol kuantitas (+/-), kalkulasi subtotal otomatis.",
            "Biaya khusus proteksi pengiriman: Penambahan otomatis biaya packing tabung oksigen murni & sterofoam tebal anti guncangan."
        ], "059669"),
        ("Pertemuan 8 (Minggu 4) — Checkout Pengiriman Hewan Hidup & Payment Gateway (UTS)", "STATUS: SELESAI (100% COMPLETE - UTS)", [
            "Alur Checkout khusus hewan hidup (/checkout): Data lengkap penerima (Nama, Email, WhatsApp aktif, Provinsi, Kota, Kecamatan, Alamat, Kode Pos).",
            "Pilihan kurir ekspedisi kilat terpercaya (JNE YES / TIKI ONS) khusus pengiriman hewan hidup 1 malam sampai.",
            "Pilihan metode pembayaran: Transfer Bank (BCA, Mandiri, BRI), QRIS Instan, dan Virtual Account.",
            "Validasi jaminan Death On Arrival (D.O.A): Garansi hidup 100% dengan syarat video unboxing utuh tanpa jeda.",
            "Evaluasi UTS Lulus: Pembuatan pesanan unik (BTC-YYYYMMDD-XXXX), pengurangan stok otomatis, dan halaman konfirmasi pembayaran (/orders/{order_number})."
        ], "059669"),
        ("Pertemuan 9 (Minggu 5) — Modul Edukasi, Panduan Cupang & Cross-Selling Produk", "STATUS: SELESAI (100% COMPLETE)", [
            "CMS Edukasi & Blog Perawatan Cupang (/articles): Panduan racikan air ketapang, pakan alami jentik/daphnia, diagnosis penyakit fin rot/velvet, dan teknik breeding.",
            "Fitur Cross-Selling: Menampilkan rekomendasi spesimen ikan cupang terkait di bagian bawah setiap artikel panduan dengan tombol beli langsung.",
            "Sistem Wishlist & Favorit (/wishlist): Kolektor cupang dapat menyimpan dan menandai ikan impian dengan toggle cepat serta memindahkannya ke keranjang.",
            "Admin CMS Artikel (/admin/articles): Editor penulisan panduan, manajemen topik kategori, dan pengaturan relasi produk cupang yang dipromosikan."
        ], "059669"),
        ("Pertemuan 10 (Minggu 6) — Pelacakan Ekspedisi Khusus Ikan & Notifikasi WhatsApp", "STATUS: SELESAI (100% COMPLETE)", [
            "Live Tracking Pengiriman Ikan Hidup (/tracking): Stepper visual 6 tahapan (Pesanan Diterima -> Pembayaran Valid -> Puasa & Karantina Ikan -> Packing Oksigen & Box -> Dalam Pengiriman Kilat -> Tiba Selamat).",
            "Pencarian nomor resi ekspedisi live dengan link kurir langsung.",
            "Integrasi Direct WhatsApp Notification (wa.me) dengan pesan template otomatis berisi nomor pesanan, total belanja, dan konfirmasi bukti bayar ke admin / pelanggan.",
            "Modul Ulasan & Rating Spesimen: Pelanggan yang telah mengadopsi dapat memberikan rating bintang 1-5 dan testimoni kondisi ikan di halaman soliter showcase."
        ], "059669"),
        ("Pertemuan 11 (Minggu 7) — Laporan Penjualan, Dashboard Analitik & Optimasi Kinerja", "STATUS: SELESAI (100% COMPLETE)", [
            "Dashboard Analitik & Laporan Penjualan (/admin/reports): Metrik total omzet, total pesanan lunas, jumlah ekor cupang terjual, dan rata-rata nilai order (AOV).",
            "Filter periode waktu: Semua Waktu, Bulan Berjalan, dan 30 Hari Terakhir.",
            "Fitur Ekspor Pembukuan ke Excel (.csv) ber-BOM UTF-8 siap cetak akuntansi toko.",
            "Fitur Cetak Rekapitulasi Laporan Penjualan Resmi Toko (/admin/reports/print) siap cetak PDF/kertas.",
            "Manajemen Pesanan Admin (/admin/orders): Pembaruan status ekspedisi, verifikasi bukti transfer, dan input nomor resi kurir."
        ], "059669"),
        ("Pertemuan 12 (Minggu 8) — Final Testing, Uji Coba Transaksi & Deployment (UAS)", "STATUS: SELESAI (100% COMPLETE - UAS)", [
            "End-to-End Testing alur belanja lengkap dari registrasi/login -> penjelajahan katalog filter -> soliter showcase -> keranjang -> checkout -> pembayaran -> live tracking -> ulasan.",
            "Automated Testing Suite: 20 Feature Tests PHPUnit dengan 109 assertions berhasil lulus 100% tanpa error.",
            "Standarisasi Kode: Diformat bersih menggunakan Laravel Pint Code Formatter.",
            "Dokumentasi Lengkap Proyek & Panduan Presentasi Sidang UAS.",
            "Aplikasi siap didemokan dan dideploy secara sempurna pada Laragon / hosting VPS."
        ], "059669"),
    ]

    for title, status, tasks, color_hex in weeks:
        wp = doc.add_paragraph()
        style_heading(wp, title, 11, True, (15, 23, 42))
        
        # Status Badge text
        sp = doc.add_paragraph()
        sp.paragraph_format.space_after = Pt(4)
        s_run = sp.add_run(f"[{status}]")
        s_run.font.name = 'Arial'
        s_run.font.size = Pt(9.5)
        s_run.font.bold = True
        if "SELESAI" in status:
            s_run.font.color.rgb = RGBColor(5, 150, 105)
        elif "UTS" in status or "UAS" in status:
            s_run.font.color.rgb = RGBColor(217, 119, 6)
        else:
            s_run.font.color.rgb = RGBColor(2, 132, 199)

        for t in tasks:
            tp = doc.add_paragraph(style='List Bullet')
            tp.paragraph_format.space_before = Pt(1)
            tp.paragraph_format.space_after = Pt(2)
            tr = tp.add_run(t)
            tr.font.name = 'Arial'
            tr.font.size = Pt(9.5)
            tr.font.color.rgb = RGBColor(51, 65, 85)

    # 3. Kredensial & Akses
    style_heading(doc.add_paragraph(), "3. INFORMASI KREDENSIAL LOGIN & AKSES SISTEM", 13, True, (15, 23, 42))
    cred_table = doc.add_table(rows=3, cols=4)
    cred_table.alignment = WD_TABLE_ALIGNMENT.CENTER
    c_heads = ["Role Akun", "Alamat Email", "Password", "Akses Fitur"]
    for c_idx, h in enumerate(c_heads):
        cell = cred_table.rows[0].cells[c_idx]
        set_cell_background(cell, "0F172A")
        set_cell_margins(cell, top=100, bottom=100, left=100, right=100)
        p = cell.paragraphs[0]
        p.paragraph_format.space_after = Pt(0)
        r = p.add_run(h)
        r.font.name = 'Arial'
        r.font.size = Pt(9.5)
        r.font.bold = True
        r.font.color.rgb = RGBColor(255, 255, 255)

    creds = [
        ("Super Admin", "admin@pamulangfish.com", "password", "Akses penuh Dashboard Admin, Katalog Cupang, Penjualan, Theme Editor"),
        ("Customer Demo", "customer@pamulangfish.com", "password", "Akses Frontend, Keranjang, Transaksi Pembelian Cupang, Status Pesanan"),
    ]
    for row_idx, data in enumerate(creds, start=1):
        row = cred_table.rows[row_idx]
        for col_idx, text in enumerate(data):
            cell = row.cells[col_idx]
            set_cell_background(cell, "F8FAFC" if row_idx == 1 else "FFFFFF")
            set_cell_margins(cell, top=80, bottom=80, left=100, right=100)
            p = cell.paragraphs[0]
            p.paragraph_format.space_after = Pt(0)
            r = p.add_run(text)
            r.font.name = 'Arial'
            r.font.size = Pt(9)
            if col_idx in (1, 2):
                r.font.bold = True
                r.font.color.rgb = RGBColor(2, 132, 199)
            else:
                r.font.color.rgb = RGBColor(51, 65, 85)

    # Save to file
    output_filename = "ROADMAP_PENGERJAAN_PAMULANG_FISH_PERTEMUAN_5_12.docx"
    doc.save(output_filename)
    print(f"Document successfully created and saved as {output_filename} ({os.path.getsize(output_filename)} bytes)")

if __name__ == "__main__":
    create_document()
