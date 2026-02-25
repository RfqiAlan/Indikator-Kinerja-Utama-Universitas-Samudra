# Sistem Informasi Indikator Kinerja Utama (IKU) - Universitas Samudra

Sistem Informasi Indikator Kinerja Utama (IKU) adalah sebuah aplikasi berbasis web yang dikembangkan khusus untuk mengelola, melacak, menganalisis, dan melaporkan capaian 11 Indikator Kinerja Utama di seluruh program studi maupun tingkat fakultas di lingkungan Universitas Samudra.

Aplikasi ini bertujuan untuk mengefisienkan proses pelaporan borang dan evaluasi capaian universitas dengan memberikan rekapitulasi real-time melalui *dashboard* visual yang komprehensif, terstruktur, dan akuntabel.

## 🚀 Fitur Utama

- **Manajemen 11 Indikator IKU Terpadu** <br>
  Sistem mendukung input, edit, dan kalkulasi otomatis untuk seluruh IKU (IKU 1 - IKU 11) sesuai dengan standar pedoman Indikator Kinerja Utama Perguruan Tinggi.
- **Multi-Role Authentication** <br>
  Sistem dirancang dengan pembedaan hak akses yang tegas:
  - **Admin**: Memiliki kontrol penuh atas sistem, manajemen pengguna (fakultas), pemantauan log aktivitas, serta akses ke agregasi data seluruh fakultas.
  - **User (Fakultas)**: Memiliki akses pengelolaan data yang secara eksklusif dibatasi hanya untuk fakultas masing-masing.
- **Dashboard Visual & Analitik** <br>
  Menyajikan visualisasi data interaktif untuk mempermudah pemantauan capaian. Termasuk di dalamnya adalah grafik perbandingan capaian antar tahun akademik (*Year-over-Year Comparison*) dan rekapitulasi kontribusi per fakultas.
- **Integrasi Penyimpanan Cloud (Google Drive)** <br>
  Dokumen dan berkas bukti dukung (*E-Evidence*) yang diunggah secara mulus dialirkan dan disimpan langsung ke dalam *Google Drive* institusi. Hal ini memastikan keamanan data dan efisiensi penyimpanan server lokal.
- **Export Pelaporan Eksekutif** <br>
  Mendukung fungsi export (unduh) laporan rekapitulasi capaian IKU per tahun akademik ke dalam format spreadsheet (`.xlsx`) untuk mempermudah proses pelaporan fisik, rapat pimpinan, dan akreditasi.
- **Validasi Integritas Data** <br>
  Sistem dilengkapi dengan validasi input ketat (mencegah duplikasi data berdasarkan kombinasi Tahun Akademik & Fakultas) untuk menjamin akurasi dan integritas data pelaporan.
- **Activity Log & Audit Trail** <br>
  Setiap modifikasi data dan aktivitas pengguna dicatat oleh sistem secara otomatis. Hal ini krusial untuk menjaga akuntabilitas dan jejak operasi data (audit) di masa mendatang.

## �️ Stack Teknologi

Sistem Informasi IKU ini dibangun menggunakan infrastruktur teknologi web modern untuk memastikan skalabilitas dan keandalan performa:

- **Framework Backend**: Laravel (PHP)
- **Framework UI / Frontend**: Tailwind CSS & Laravel Blade
- **Arsitektur Database**: MySQL / MariaDB
- **Visualisasi Data**: Chart.js
- **Integrasi Layanan External**: Google Drive API

---

*Dikembangkan untuk lingkungan internal institusi akademik **Universitas Samudra** sebagai instrumen tata kelola, pendataan, dan pelaporan IKU.*
