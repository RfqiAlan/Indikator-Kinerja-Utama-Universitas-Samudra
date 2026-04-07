# Product Requirements Document (PRD)
**Project Name**: Sistem Indikator Kinerja Utama (IKU) Universitas Samudra
**Version**: 1.0 (Berdasarkan kondisi *codebase* saat ini)

---

## 1. Pendahuluan
### 1.1 Latar Belakang
Universitas Samudra memerlukan platform terpusat dan modern untuk mendata, memantau, dan melaporkan Indikator Kinerja Utama (IKU) dari seluruh fakultas dan unit kerja. Sebelum adanya sistem ini, pendataan mungkin terfragmentasi dan sulit dilacak secara *real-time*.

### 1.2 Tujuan Sistem
Mengotomatisasi agregasi data 11 Indikator Kinerja Utama sesuai standar pelaporan pendidikan tinggi sehingga pimpinan (/Admin) maupun Fakultas (/User) dapat dengan mudah dan tertata mendaftarkan pencapaian, meninjau persentase secara instan, serta mengukur apakah masing-masing target (KPI) berhasil dipenuhi.

---

## 2. Platform & Target Pengguna
- **Jenis Platform**: Web Application (Laravel, merender antarmuka Blade menggunakan desain premium *Glassmorphism* dan interaktivitas Alpine.js + TailwindCSS).
- **Target Pengguna**:
  1. **User (Fakultas/Prodi)**: Memasukkan data mentah dari civitas akademika ke dalam masing-masing formulir IKU.
  2. **Admin (Tingkat Universitas/UPT TIK)**: Melihat seluruh rekapan aktivitas, mengelola *users*, falkutas/prodi, serta memantau semua rangkuman *(dashboard)* tanpa harus mengentri data.

---

## 3. Fitur Utama (Core Features)

### 3.1 Autentikasi dan Manajemen Hak Akses
- **Login/Logout**: Otentikasi standar yang memitigasi akses tanpa hak. Termasuk pemisahan jelas antara Dashboard Admin dan Dashboard User.
- **Profil Pengguna**: Setiap User dikaitkan secara spesifik ke *Fakultas* tertentu sehingga sistem otomatis melakukan partisi/isolasi data hanya ke fakultas terkait.
- **Admin Setup**: Admin dapat melakukan manajemen *(CRUD)* terhadap User beserta *password reset* dan pengaturan status keaktifannya.

### 3.2 Modul 11 Indikator Kinerja Utama (IKU)
Sistem memiliki fasilitas *Input, Dashboard, Perhitungan (Calculation Logic), Edit, dan Delete* pada sebelas IKU:
- **IKU 1**: Angka Efisiensi Edukasi (Kelulusan tepat waktu per jenjang).
- **IKU 2**: Lulusan Produktif (Mahasiswa yang langsung Bekerja, Studi Lanjut, atau Wirausaha).
- **IKU 3**: Mahasiswa Berkegiatan di Luar Kampus/Prodi.
- **IKU 4**: Rekognisi Dosen (Inovasi global, praktisi lintas internasional).
- **IKU 5**: Rasio Luaran Kerja Sama dengan Industri.
- **IKU 6**: Publikasi Scopus/Web of Science (Q1-Q4).
- **IKU 7**: Keterlibatan SDGs (Proyek berorientasi *Sustainability*).
- **IKU 8**: SDM Penyusun Kebijakan.
- **IKU 9**: Pendapatan Non-UKT (Hibah eksternal, layanan berbayar, atau donasi/royalti).
- **IKU 10**: Zona Integritas (WBK/WBBM pada tataran unit).
- **IKU 11**: Tata Kelola Keuangan Universitas (SAKIP, WTP).

*Khusus pada tiap halaman IKU, disertakan kalkulasi real-time *(Circular Progress Bar)* yang memberi peringatan warna (Hijau/Merah) menyesuaikan dengan capaian berbanding Target Universitas.*

### 3.3 Dashboard Eksekutif & Repositori *Filter* Khusus
- **Master Data (User/IKU)**: Menampilkan antarmuka panel melayang *(Bento Grid Glassmorphism)* yang merangkum persentase dari keseluruhan ke-11 IKU fakultas yang sedang masuk.
- **Filter Tahun**: Kemampuan menyerap parameter HTTP / URL (`?tahun=XXXX`) guna meregenerasi seluruh status ringkasan performa di tahun-tahun akademik yang berbeda secara mulus.
- **Admin Dashboard**: Memberikan sudut pandang luas atas seluruh Universitas.

### 3.4 Google Drive Storage Overlay
- **Integrasi Dokumen**: Fungsi unggul di mana aplikasi dapat menerima penyimpanan arsip PDF dan disentralisasi ke dalam Google Drive eksternal *(melalui GoogleDriveOauthController)* demi penghematan kuota disk server lokal dan durabilitas berkas jaminan Mutu/Akreditasi IKU.

---

## 4. Persyaratan Non-Fungsional (Non-Functional Requirements)

### 4.1 UI/UX & Tampilan Visual
1. Wajib **Responsif** (menyesuaikan layar Ponsel hingga Monitor *Ultrawide*).
2. Estetika berada pada level premium/startup standar tinggi: Penggunaan tebar bayangan (*shadow glow*), grafik lingkaran interaktif (*Circular Progress*), bingkai transparan *(Glassmorphism)*, *blur backdrops*, animasi masuk (*aos/fade-up*), dan pewarnaan *gradient* berkelas.

### 4.2 Keamanan
1. Perlindungan Formulir via CSRF Token (Standar Laravel).
2. Partisi Hak Akses ketat *(Role-Based Access Control)*: `Admin` tidak bisa memasukkan data seakan dia User, sebaliknya `User` tidak bisa melihat hasil dari Fakultas lain atau mengganti data akun.

---

## 5. Alur Data dan Proses (High-Level)
1. **User Login** ➡️ Mengakses Dashboard ➡️ Memilih Tahun Akademik ➡️ Mengakses halaman salah satu IKU (misalnya IKU 4).
2. **Lihat Rangkuman** ➡️ Platform memanggil Query ke database, mengambil `Total_Dosen` dan `Total_Rekognisi`, menghasilkan rasio %.
3. **Mengisi Data** ➡️ Masuk ke halaman Tambah ➡️ Memilih Prodi ➡️ Menginputkan angka absolut / data dukung.
4. **Hasil** ➡️ Dashboard diperbarui secara langsung dengan animasi peningkatkan capaian data terbaru secara visual.
