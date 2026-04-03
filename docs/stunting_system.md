# Dokumentasi Sistem Informasi Deteksi dan Pemantauan Risiko Stunting

## 📋 Ringkasan Project

**Nama Project:** Sistem Informasi Berbasis Website untuk Deteksi dan Pemantauan Risiko Stunting pada Anak

**Tujuan Utama:**
- Membantu orang tua memantau pertumbuhan anak
- Mendeteksi risiko stunting secara dini menggunakan AI (Artificial Neural Network)
- Menyediakan akses konsultasi online dengan tenaga kesehatan
- Memberikan saran makanan dan tindakan berdasarkan hasil deteksi

---

## 👥 Daftar Pengguna (User Roles)

### 1. Orang Tua
- Pengguna utama yang memantau pertumbuhan anaknya
- Dapat mengakses fitur deteksi, monitoring, dan konsultasi

### 2. Tenaga Kesehatan (Dokter/Ahli Gizi)
- Merespons konsultasi dari orang tua
- Memantau perkembangan gizi anak
- Memberikan rekomendasi penanganan

### 3. Admin
- Mengelola data anak
- Mengelola laporan pertumbuhan
- Membuat dan mengelola artikel kesehatan

### 4. Super Admin
- Mengelola seluruh data pengguna
- Mengatur hak akses (permission) setiap pengguna
- Mengelola konfigurasi sistem

---

## 🔧 Fitur-Fitur Sistem

### FITUR PUBLIK (Tanpa Login)

#### 1. Landing Page
- **Deskripsi:** Halaman utama website yang menampilkan informasi umum tentang sistem dan stunting
- **Komponen:**
  - Hero section dengan penjelasan singkat
  - Statistik stunting di Indonesia
  - Fitur-fitur unggulan sistem
  - Call-to-action untuk deteksi dan registrasi
  - Testimoni pengguna
- **Akses:** Semua pengunjung

#### 2. Halaman Artikel Edukasi Stunting
- **Deskripsi:** Kumpulan artikel edukasi tentang stunting, gizi anak, dan tips parenting
- **Komponen:**
  - Daftar artikel dengan thumbnail dan ringkasan
  - Kategori artikel (pencegahan, penanganan, nutrisi, dll)
  - Detail artikel dengan konten lengkap
  - Fitur pencarian artikel
- **Akses:** Semua pengunjung

#### 3. Fitur Deteksi Risiko Stunting (Guest Mode)
- **Deskripsi:** Fitur utama untuk mendeteksi risiko stunting tanpa perlu login
- **Input Data Antropometri:**
  - Jenis kelamin anak (Laki-laki/Perempuan)
  - Usia anak (dalam bulan)
  - Tinggi badan anak (dalam cm)
- **Output:**
  - Status risiko stunting (Normal/Berisiko/Stunting)
  - Penjelasan hasil deteksi
  - Saran umum makanan dan tindakan
  - Rekomendasi untuk registrasi agar dapat monitoring berkelanjutan
- **Teknologi:** Model Artificial Neural Network (ANN)
- **Akses:** Semua pengunjung

---

### FITUR ORANG TUA (Perlu Login)

#### 4. Registrasi dan Login
- **Deskripsi:** Sistem autentikasi untuk orang tua
- **Registrasi - Input:**
  - Nama lengkap
  - Email
  - Password
  - Nomor telepon
  - Alamat (opsional)
- **Login - Input:**
  - Email
  - Password
- **Fitur Tambahan:**
  - Lupa password (reset via email)
  - Verifikasi email (opsional)

#### 5. Dashboard Orang Tua
- **Deskripsi:** Halaman utama setelah login untuk orang tua
- **Komponen:**
  - Ringkasan data anak yang terdaftar
  - Grafik pertumbuhan anak terbaru
  - Notifikasi/pengingat pemeriksaan
  - Quick access ke fitur utama
  - Riwayat deteksi terakhir

#### 6. Manajemen Data Anak
- **Deskripsi:** CRUD data anak milik orang tua
- **Data Anak:**
  - Nama anak
  - Tanggal lahir
  - Jenis kelamin
  - Berat badan lahir
  - Panjang badan lahir
  - Foto anak (opsional)
- **Fitur:**
  - Tambah anak baru
  - Edit data anak
  - Hapus data anak
  - Lihat detail anak

#### 7. Fitur Deteksi Risiko Stunting (Logged In)
- **Deskripsi:** Deteksi risiko stunting dengan penyimpanan riwayat
- **Input:**
  - Pilih anak yang akan diperiksa
  - Tinggi badan terkini (cm)
  - Berat badan terkini (kg) - opsional untuk data tambahan
  - Tanggal pemeriksaan
- **Output:**
  - Status risiko stunting
  - Z-score
  - Perbandingan dengan standar WHO
  - Saran makanan berdasarkan hasil
  - Saran tindakan berdasarkan hasil
- **Penyimpanan:** Hasil otomatis tersimpan ke riwayat

#### 8. Dashboard Monitoring Pertumbuhan Anak
- **Deskripsi:** Visualisasi perkembangan pertumbuhan anak dari waktu ke waktu
- **Komponen:**
  - Grafik tinggi badan vs usia (dengan kurva standar WHO)
  - Grafik berat badan vs usia
  - Grafik Z-score dari waktu ke waktu
  - Tabel riwayat pengukuran
  - Indikator status gizi (warna: hijau/kuning/merah)
- **Filter:**
  - Pilih anak
  - Rentang waktu (1 bulan, 3 bulan, 6 bulan, 1 tahun, semua)

#### 9. Riwayat Deteksi Risiko Stunting
- **Deskripsi:** Catatan semua hasil deteksi yang pernah dilakukan
- **Komponen:**
  - Daftar riwayat deteksi per anak
  - Tanggal pemeriksaan
  - Hasil status (Normal/Berisiko/Stunting)
  - Detail hasil (tinggi, usia, Z-score)
  - Saran yang diberikan saat itu
- **Fitur:**
  - Filter berdasarkan anak
  - Filter berdasarkan tanggal
  - Export riwayat ke PDF

#### 10. Fitur Konsultasi Online
- **Deskripsi:** Komunikasi dengan tenaga kesehatan
- **Tipe Konsultasi:**
  - **Live Chat:** Pesan real-time dengan dokter/ahli gizi
  - **Konsultasi Terjadwal:** Booking jadwal konsultasi
- **Komponen Chat:**
  - Daftar percakapan
  - Room chat dengan tenaga kesehatan
  - Kirim pesan teks
  - Kirim gambar/foto (hasil lab, makanan anak, dll)
  - Riwayat chat
- **Komponen Booking:**
  - Pilih tenaga kesehatan
  - Lihat jadwal tersedia
  - Pilih tanggal dan waktu
  - Deskripsi keluhan/pertanyaan
  - Konfirmasi booking

#### 11. Saran Makanan dan Tindakan
- **Deskripsi:** Rekomendasi berdasarkan hasil deteksi
- **Saran Makanan:**
  - Daftar makanan yang direkomendasikan
  - Kandungan gizi makanan
  - Resep makanan sehat untuk anak
  - Jadwal makan yang disarankan
- **Saran Tindakan:**
  - Langkah-langkah yang harus dilakukan
  - Kapan harus ke dokter/puskesmas
  - Tips perawatan harian
  - Aktivitas fisik yang direkomendasikan

#### 12. Profil Orang Tua
- **Deskripsi:** Manajemen data profil orang tua
- **Fitur:**
  - Lihat profil
  - Edit profil (nama, email, telepon, alamat)
  - Ganti password
  - Pengaturan notifikasi

---

### FITUR TENAGA KESEHATAN (Perlu Login)

#### 13. Dashboard Tenaga Kesehatan
- **Deskripsi:** Halaman utama untuk dokter/ahli gizi
- **Komponen:**
  - Jumlah pasien yang ditangani
  - Konsultasi pending/menunggu
  - Jadwal konsultasi hari ini
  - Quick stats

#### 14. Manajemen Konsultasi
- **Deskripsi:** Mengelola konsultasi dari orang tua
- **Fitur:**
  - Daftar konsultasi masuk
  - Filter: pending, ongoing, completed
  - Respons chat
  - Lihat riwayat konsultasi dengan pasien
  - Tandai konsultasi selesai

#### 15. Pemantauan Perkembangan Gizi Anak
- **Deskripsi:** Melihat data pertumbuhan anak yang dikonsultasikan
- **Fitur:**
  - Lihat data anak pasien
  - Lihat grafik pertumbuhan anak
  - Lihat riwayat deteksi stunting
  - Berikan catatan/rekomendasi

#### 16. Profil Tenaga Kesehatan
- **Deskripsi:** Manajemen profil tenaga kesehatan
- **Data Profil:**
  - Nama lengkap
  - Spesialisasi (Dokter Umum/Dokter Anak/Ahli Gizi)
  - Nomor STR/Sertifikasi
  - Jadwal praktik
  - Foto profil
- **Fitur:**
  - Edit profil
  - Atur jadwal ketersediaan
  - Ganti password

---

### FITUR ADMIN (Perlu Login)

#### 17. Dashboard Admin
- **Deskripsi:** Overview sistem untuk admin
- **Komponen:**
  - Total pengguna terdaftar
  - Total anak terdaftar
  - Total deteksi dilakukan
  - Grafik statistik bulanan
  - Aktivitas terbaru

#### 18. Manajemen Data Anak
- **Deskripsi:** Kelola semua data anak dalam sistem
- **Fitur:**
  - Lihat daftar semua anak
  - Filter berdasarkan status gizi
  - Filter berdasarkan wilayah
  - Export data ke Excel/PDF
  - Detail data anak

#### 19. Manajemen Laporan Pertumbuhan
- **Deskripsi:** Generate dan kelola laporan
- **Jenis Laporan:**
  - Laporan deteksi stunting (harian/mingguan/bulanan)
  - Laporan per wilayah
  - Laporan tren pertumbuhan
  - Laporan konsultasi
- **Fitur:**
  - Generate laporan
  - Preview laporan
  - Download PDF/Excel
  - Cetak laporan

#### 20. Manajemen Artikel Kesehatan
- **Deskripsi:** CRUD artikel edukasi
- **Data Artikel:**
  - Judul artikel
  - Kategori
  - Konten (rich text editor)
  - Thumbnail/gambar
  - Status (draft/published)
  - Tanggal publish
- **Fitur:**
  - Buat artikel baru
  - Edit artikel
  - Hapus artikel
  - Preview artikel
  - Publish/Unpublish artikel

---

### FITUR SUPER ADMIN (Perlu Login)

#### 21. Dashboard Super Admin
- **Deskripsi:** Overview lengkap sistem
- **Komponen:**
  - Semua statistik dari dashboard admin
  - Status sistem
  - Log aktivitas
  - Alert/warning sistem

#### 22. Manajemen Pengguna
- **Deskripsi:** Kelola semua pengguna sistem
- **Fitur:**
  - Daftar semua pengguna
  - Filter berdasarkan role
  - Tambah pengguna baru (admin/tenaga kesehatan)
  - Edit data pengguna
  - Nonaktifkan/aktifkan pengguna
  - Reset password pengguna

#### 23. Manajemen Hak Akses (Permission)
- **Deskripsi:** Atur permission setiap role
- **Fitur:**
  - Daftar roles
  - Buat role baru
  - Atur permission per role
  - Assign role ke pengguna
- **Permission yang dapat diatur:**
  - Akses menu tertentu
  - CRUD data tertentu
  - Export/cetak laporan
  - dll.

#### 24. Konfigurasi Sistem
- **Deskripsi:** Pengaturan sistem secara global
- **Fitur:**
  - Pengaturan website (nama, logo, kontak)
  - Pengaturan email notification
  - Pengaturan model AI (parameter)
  - Backup database
  - Log sistem

---

## 🛠️ Tech Stack

### Backend
- **Framework:** Laravel (PHP)
- **Database:** MySQL
- **Authentication:** Laravel Sanctum / JWT
- **API:** RESTful API

### Frontend
- **Framework:** React JS
- **UI Library:** Radix UI
- **Styling:** Tailwind CSS (opsional)
- **HTTP Client:** Axios
- **State Management:** React Context / Redux (opsional)

### Machine Learning
- **Bahasa:** Python
- **Library:** TensorFlow, Keras
- **API Server:** Flask
- **Model:** Artificial Neural Network (ANN)
  - Input: jenis_kelamin, usia_bulan, tinggi_badan
  - Output: klasifikasi risiko stunting (normal/berisiko/stunting)
  - Arsitektur: 3 hidden layers (32, 64, 128 neuron)
  - Aktivasi: Softmax
  - Optimizer: Adam
  - Loss: Categorical Crossentropy

### Integrasi
- Backend Laravel menyediakan REST API
- Frontend React mengonsumsi API
- Model ML di-deploy sebagai Flask API terpisah
- Laravel memanggil Flask API untuk prediksi

---

## 📱 Halaman-Halaman Utama
 
### Public Pages
1. Landing Page (`/`)
2. Articles List (`/articles`)
3. Article Detail (`/articles/:slug`)
4. Stunting Detection Guest (`/detection`)
5. Login (`/login`)
6. Register (`/register`)
7. Forgot Password (`/forgot-password`)
8. Reset Password (`/reset-password/:token`)
 
### Parent Pages (Orang Tua)
1. Dashboard (`/dashboard`)
2. Children List (`/children`)
3. Create Child (`/children/create`)
4. Edit Child (`/children/:id/edit`)
5. Child Detail (`/children/:id`)
6. Stunting Detection (`/stunting-detection`)
7. Detection Result (`/stunting-detection/result/:id`)
8. Growth Monitoring (`/monitoring`)
9. Detection History (`/detection-history`)
10. Consultation (`/consultation`)
11. Chat Room (`/consultation/chat/:id`)
12. Booking Consultation (`/consultation/booking`)
13. Food Recommendations (`/food-recommendations`)
14. Profile (`/profile`)
15. Edit Profile (`/profile/edit`)
16. Change Password (`/profile/change-password`)
 
### Health Worker Pages (Tenaga Kesehatan)
1. Dashboard (`/health-worker/dashboard`)
2. Consultation List (`/health-worker/consultations`)
3. Consultation Chat (`/health-worker/consultations/chat/:id`)
4. Patient List (`/health-worker/patients`)
5. Patient Detail (`/health-worker/patients/:id`)
6. Profile (`/health-worker/profile`)
7. Schedule (`/health-worker/schedule`)
 
### Admin Pages
1. Dashboard (`/admin/dashboard`)
2. Children Data (`/admin/children`)
3. Child Detail (`/admin/children/:id`)
4. Reports (`/admin/reports`)
5. Articles List (`/admin/articles`)
6. Create Article (`/admin/articles/create`)
7. Edit Article (`/admin/articles/:id/edit`)
8. Food Data (`/admin/foods`)
9. Create Food (`/admin/foods/create`)
10. Edit Food (`/admin/foods/:id/edit`)
 
### Super Admin Pages
1. Dashboard (`/super-admin/dashboard`)
2. User Management (`/super-admin/users`)
3. Create User (`/super-admin/users/create`)
4. Edit User (`/super-admin/users/:id/edit`)
5. Roles & Permissions (`/super-admin/roles`)
6. Create Role (`/super-admin/roles/create`)
7. Edit Role (`/super-admin/roles/:id/edit`)
8. Configuration (`/super-admin/configuration`)
9. System Logs (`/super-admin/logs`)
 
---

## 🔄 Alur Proses Utama

### Alur Deteksi Risiko Stunting
```
1. User membuka halaman deteksi
2. User memilih anak (jika login) atau input manual (guest)
3. User input: jenis kelamin, usia (bulan), tinggi badan (cm)
4. Frontend kirim data ke Backend API
5. Backend forward data ke Flask ML API
6. Model ANN memproses dan return prediksi
7. Backend menyimpan hasil ke database (jika login)
8. Backend return hasil + saran ke Frontend
9. Frontend menampilkan hasil:
   - Status: Normal / Berisiko / Stunting
   - Z-score
   - Grafik perbandingan dengan standar WHO
   - Saran makanan
   - Saran tindakan
```

### Alur Konsultasi Online (Chat)
```
1. Orang tua membuka menu konsultasi
2. Pilih "Mulai Konsultasi Baru" atau lanjutkan yang ada
3. Jika baru: pilih tenaga kesehatan yang tersedia
4. Masuk ke room chat
5. Kirim pesan / foto
6. Tenaga kesehatan menerima notifikasi
7. Tenaga kesehatan merespons
8. Chat berlanjut sampai selesai
9. Tenaga kesehatan menandai "Selesai"
10. Konsultasi masuk ke riwayat
```

### Alur Monitoring Pertumbuhan
```
1. Orang tua login
2. Buka menu monitoring
3. Pilih anak
4. Sistem load data pertumbuhan dari database
5. Tampilkan:
   - Grafik TB/U (tinggi badan per usia)
   - Grafik BB/U (berat badan per usia)
   - Kurva standar WHO sebagai pembanding
   - Tabel riwayat pengukuran
6. Orang tua dapat tambah data pengukuran baru
7. Grafik dan status update real-time
```

---

## 📌 Catatan Penting

### Batasan Sistem
1. Hasil deteksi bersifat **skrining awal**, bukan diagnosis medis
2. Deteksi berdasarkan data antropometri: jenis kelamin, tinggi badan, usia
3. Sistem tidak menggantikan pemeriksaan langsung oleh tenaga kesehatan

### Standar yang Digunakan
- **WHO Child Growth Standards** untuk perhitungan Z-score
- **Indikator TB/U (Tinggi Badan per Usia)** untuk deteksi stunting

### Klasifikasi Status
- **Normal:** Z-score ≥ -2 SD
- **Berisiko (Pendek):** Z-score < -2 SD s/d ≥ -3 SD
- **Stunting (Sangat Pendek):** Z-score < -3 SD

---

## 🚀 Prioritas Pengembangan

### MVP (Minimum Viable Product)
1. ✅ Landing Page
2. ✅ Registrasi & Login (Orang Tua)
3. ✅ Deteksi Risiko Stunting (dengan AI)
4. ✅ Dashboard Monitoring Pertumbuhan
5. ✅ Manajemen Data Anak
6. ✅ Riwayat Deteksi

### Phase 2
1. Konsultasi Online (Chat)
2. Saran Makanan & Tindakan
3. Artikel Edukasi
4. Dashboard Admin

### Phase 3
1. Tenaga Kesehatan Features
2. Super Admin Features
3. Laporan & Export
4. Notifikasi (Email/WhatsApp)

---

*Dokumentasi ini dibuat untuk persiapan pengembangan sistem. Update sesuai kebutuhan development.*