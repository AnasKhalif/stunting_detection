# FLOW IMPLEMENTASI & PENGUJIAN — Sistem Deteksi Stunting

Dokumen ini menjadi referensi utama untuk penulisan **BAB 4.4 Implementasi** dan **BAB 4.5 Pengujian** pada sistem `stunting_detection`. Isinya mencakup arsitektur alur, data akun uji (diambil langsung dari database `gizidetection`), flow end-to-end per role (dimulai dari landing page Laravel monolith), matriks permission, prompt AI Claude untuk implementasi maupun pengujian, serta template tabel pengujian black box yang siap tempel ke laporan TA.

---

## 1) Arsitektur & Entry Point

- **Landing page publik** dilayani oleh Laravel monolith (`stunting_detection`) pada `http://localhost:8000/`.
- Tombol **Login** di header landing page mengarah ke FE React (`stunting_detection_fe`) pada `http://localhost:5173/auth/login` (lihat `resources/views/core/partials/header.blade.php`).
- **Registrasi** dilakukan di FE: `/auth/register` → `/auth/register/step-2`.
- Setelah login sukses, user diarahkan ke dashboard FE (`/dashboard`). Menu sidebar dirender berdasarkan **role**, sedangkan akses route/endpoint dikontrol oleh **permission** granular (`*-create`, `*-read`, `*-update`, `*-delete`).
- Jika user mengakses route/endpoint tanpa permission yang sesuai → sistem mengembalikan **403 Forbidden** (bukan redirect).

Komponen tech stack:
- Backend: **Laravel (PHP)** + MySQL DB `gizidetection`.
- Frontend: **React + TypeScript + Vite**, Radix UI, Tailwind.
- ML Service: **Flask API** (model ANN) untuk prediksi stunting.
- RBAC: Custom Role + Permission (model `App\Models\Role` + pivot `model_has_roles`, permission list di tabel `permissions`).

---

## 2) Data Akun Uji (Fetch dari Database)

Hasil query pada DB `gizidetection` tanggal **2026-04-18**:

| ID | Role | Nama | Email | Password Uji |
|---|---|---|---|---|
| 1 | `superadmin` | Superadmin | `superadmin@app.test` | `password123` |
| 2 | `admin` | Admin | `admin@app.test` | `password123` |
| 3 | `user` (Orang Tua) | Anas Khalif | `anas@example.com` | `password123` |
| 4 | `user` (Orang Tua) | Anas Khalif Muttaqien | `anaskhalif995@gmail.com` | `password123` |
| 5 | `dokter` | Dokter | `dokter@example.com` | `password123` |

> Password disimpan hash bcrypt. Verifikasi via `Hash::check('password123', $user->password)` menghasilkan `true` untuk kelima akun di atas.

---

## 3) Matriks Permission (Snapshot DB)

Diambil dari `App\Models\Role::with('permissions')->get()`:

### 3.1 `superadmin`
`users-create`, `users-read`, `users-update`, `users-delete`, `roles-create`, `roles-read`, `roles-update`, `roles-delete`, `log-system-read`

### 3.2 `admin`
`dashboard-read`, `users-create`, `users-update`, `users-delete`, `articles-create`, `articles-update`, `articles-delete`, `faqs-create`, `faqs-update`, `faqs-delete`, `foods-create`, `foods-update`, `foods-delete`, `children-update`, `profile-update`

### 3.3 `dokter`
`dashboard-read`, `profile-read`, `profile-update`, `foods-create`, `foods-read`, `foods-update`, `children-read`, `stunting-read`, `monitoring-read`, `consultations-create`, `consultations-read`, `consultations-update`

### 3.4 `user` (Orang Tua)
`dashboard-read`

> Catatan: permission orang tua saat ini sangat minim di DB karena modul parent (children, stunting, monitoring, consultation, foods, profile) pada FE dikontrol lewat **role** + default access. Bila dikemudian hari permission parent diperbanyak, tabel matriks ini wajib di-update.

---

## 4) Flow End-to-End Per Role (mulai dari Landing Page)

Semua role **memulai perjalanan dari landing page monolith Laravel**. Flow berikut merujuk route FE pada `src/app/constants/router.ts`.

### 4.1 Flow Orang Tua

1. Buka landing page monolith `http://localhost:8000/`.
2. Klik tombol **Login** di header → browser diarahkan ke FE `http://localhost:5173/auth/login`.
3. Jika **belum punya akun**:
   - Klik link **Register** di halaman login.
   - Isi form step-1 (`/auth/register`): nama, email, password.
   - Lanjut ke step-2 (`/auth/register/step-2`): data tambahan orang tua.
   - Sistem membuat user baru dengan role `user` → kembali ke `/auth/login`.
4. Login menggunakan akun orang tua (`anas@example.com` / `password123`).
5. FE memanggil API login Laravel → menerima token + profile → redirect ke `/dashboard`.
6. Menu sidebar orang tua (dari `StuntingParentSidebarItems.ts`):
   - **Dashboard** (`/dashboard`) — ringkasan anak, grafik pertumbuhan, riwayat deteksi terbaru.
   - **Daftar Anak** (`/children`) — CRUD data anak milik sendiri.
   - **Deteksi Risiko Stunting** (`/stunting-detection`) — input jenis kelamin, usia (bulan), tinggi (cm) → call ML API → simpan hasil.
   - **Riwayat Deteksi** (`/detection-history`) — list hasil deteksi per anak.
   - **Monitoring Pertumbuhan** (`/monitoring`) — grafik TB/U & BB/U vs kurva WHO.
   - **Konsultasi** (`/consultation`) — chat dengan dokter.
   - **Rekomendasi Makanan** (`/food-recommendations`) — saran gizi.
   - **Profil** (`/profile`) — edit profil & ganti password.
7. Logout → kembali ke `/auth/login`.

### 4.2 Flow Dokter

1. Buka landing page `http://localhost:8000/` → klik **Login** → FE `/auth/login`.
2. Login pakai akun `dokter@example.com` / `password123`.
3. FE redirect ke `/dashboard` (FE membaca role `dokter` dan merender sidebar `DoctorSidebarItems.ts`).
4. Menu sidebar dokter:
   - **Dashboard** (`/dashboard`) — statistik konsultasi pending/ongoing/selesai.
   - **Manajemen Konsultasi** (`/doctor/consultation`) — respons chat orang tua (butuh `consultations-read/update`).
   - **Daftar Pasien** (`/doctor/patients`) — daftar anak yang dikonsultasikan (butuh `children-read`).
   - **Monitoring Pasien** (`/doctor/monitoring`) — lihat grafik pertumbuhan pasien (butuh `monitoring-read`).
   - **Daftar Makanan** (`/doctor/foods`) — kelola rekomendasi makanan (butuh `foods-*`).
   - **Profil** (`/doctor/profile` / `/profile`) — butuh `profile-read/update`.
5. Jika dokter iseng mengakses `/users`, `/roles`, atau `/log-system` → backend return **403**, FE render halaman `/403`.

### 4.3 Flow Admin

1. Landing page `http://localhost:8000/` → **Login** → `/auth/login`.
2. Login dengan `admin@app.test` / `password123`.
3. Redirect ke `/dashboard` (sidebar dari `AdminSidebarItems.ts`).
4. Menu admin:
   - **Dashboard** (`/dashboard`) — `dashboard-read`.
   - **Manajemen Artikel** (`/articles`) — `articles-create/update/delete`.
   - **Manajemen FAQ** (`/faqs`) — `faqs-create/update/delete`.
   - **Daftar Makanan** (`/foods`) — `foods-create/update/delete`.
   - **Data Anak** (`/children`) — `children-update`.
   - **Laporan Pertumbuhan** (`/admin/reports`) — export PDF/CSV.
   - **Manajemen Pengguna** (`/users`) — `users-create/update/delete` (admin tidak punya `roles-*`, jadi modul role hidden).
5. Akses ke `/roles` atau `/log-system` ditolak **403**.

### 4.4 Flow Super Admin

1. Landing page `http://localhost:8000/` → **Login** → `/auth/login`.
2. Login dengan `superadmin@app.test` / `password123`.
3. Redirect ke `/dashboard` (sidebar dari `SuperAdminSidebarItems.ts`).
4. Menu super admin:
   - **Manajemen Pengguna** (`/users`) — `users-*`.
   - **Role & Permission** (`/roles`, `/roles/create`, `/roles/edit/:id`) — `roles-*`.
   - **Log System** (`/log-system`) — `log-system-read`.
5. Saat edit role dengan kombinasi **eksklusif** (misal `roles-*` + `users-*`), modul yang tampil untuk role tersebut akan menyesuaikan.
6. Super admin **tidak** otomatis punya akses modul fungsional (children, consultations, dll) karena permission-nya hanya untuk governance. Akses di luar scope → **403**.

---

## 5) Prompt AI Claude — Implementasi (BAB 4.4)

Copy-paste prompt berikut ke Claude saat mengerjakan implementasi:

```text
Anda adalah software engineer pada proyek stunting_detection.

Konteks teknis:
- Backend: Laravel (folder stunting_detection), DB MySQL `gizidetection`.
- Frontend: React + TypeScript + Vite (folder stunting_detection_fe).
- Landing page publik ada di Laravel monolith (http://localhost:8000/). Tombol Login di header mengarah ke FE (http://localhost:5173/auth/login).
- Registrasi user orang tua dilakukan di FE via /auth/register → /auth/register/step-2.
- Otorisasi berbasis Role + Permission granular (users-*, roles-*, articles-*, faqs-*, foods-*, children-*, consultations-*, monitoring-read, stunting-read, dashboard-read, profile-*, log-system-read).
- Menu sidebar dirender berdasarkan ROLE, tetapi kontrol akses route/endpoint harus berbasis PERMISSION.
- Jika user tidak punya permission, sistem WAJIB return/redirect ke halaman 403 (bukan ke dashboard).

Role yang ada:
- superadmin — governance (users, roles, log system).
- admin — manajemen konten (articles, faqs, foods, children, users, reports).
- dokter — layanan klinis (consultations, patients, monitoring, foods, profile).
- user — orang tua (children, stunting detection, history, monitoring, consultation, foods, profile).

Tugas implementasi:
1. Pastikan route guard FE mengecek permission spesifik. Fallback ke /403 bila gagal.
2. Pastikan setiap endpoint backend menerapkan middleware permission (bukan hanya role). Response 403 JSON bila ditolak.
3. Verifikasi flow per role berikut dapat diselesaikan end-to-end tanpa error:
   - Orang Tua: register step-1 → step-2 → login → CRUD children → deteksi stunting → lihat history & monitoring → chat konsultasi → lihat food recommendations → edit profil.
   - Dokter: login → respons konsultasi → lihat daftar pasien & monitoring → kelola foods → edit profil.
   - Admin: login → CRUD articles, faqs, foods → update data children → lihat/export reports → CRUD users.
   - Super Admin: login → CRUD users → CRUD roles & permission → lihat log-system.
4. Gunakan permission granular *-create / *-read / *-update / *-delete untuk tiap aksi CRUD.
5. Tampilkan patch code per file + alasan singkat setiap perubahan.
6. Akhiri dengan checklist verifikasi manual (curl/ui steps) untuk memastikan 403 muncul di skenario negatif.
```

---

## 6) Prompt AI Claude — Pengujian Black Box (BAB 4.5)

```text
Bantu saya menyusun dokumen pengujian black box sistem stunting_detection untuk BAB 4.5 TA.

Format tabel per halaman (No, Deskripsi, Prosedur Pengujian, Masukan, Keluaran Diharapkan, Hasil Didapatkan, Kesimpulan).

Halaman/fitur yang diuji:
1. Landing Page (link ke FE login & register).
2. Register (step-1 & step-2).
3. Login (valid, password salah, format email salah, akun tidak terdaftar).
4. Dashboard Orang Tua / Dokter / Admin / Super Admin.
5. Children (CRUD oleh orang tua, read oleh dokter, update oleh admin).
6. Stunting Detection (input valid & invalid).
7. Detection History.
8. Monitoring Pertumbuhan.
9. Consultation (chat, status konsultasi).
10. Food Recommendations (orang tua) & Foods Management (admin/dokter).
11. Articles (admin CRUD).
12. FAQs (admin CRUD).
13. Reports (admin export PDF/CSV).
14. Users Management (admin & superadmin).
15. Roles & Permission (superadmin).
16. Log System (superadmin).
17. 403 Forbidden (akses cross-role tanpa permission).

Akun uji (ambil dari DB gizidetection):
- Super Admin: superadmin@app.test / password123
- Admin: admin@app.test / password123
- Dokter: dokter@example.com / password123
- Orang Tua: anas@example.com / password123

Tiap modul minimal berisi:
- 2 skenario positif,
- 2 skenario negatif (input invalid / data tidak ditemukan),
- 1 skenario kontrol akses (akses ditolak 403).

Output: langsung siap tempel ke dokumen TA Microsoft Word / Google Docs.
```

---

## 7) Template BAB 4.4 Implementasi (kerangka tulisan)

1. **Halaman Landing Page** — dikases semua pengunjung dari Laravel monolith. Berisi hero, artikel edukasi, kalkulator deteksi guest, dan tombol Login yang mengarah ke FE.
2. **Halaman Register** — step-1 (data akun) & step-2 (data orang tua) di FE React. Menghasilkan user baru dengan role `user`.
3. **Halaman Login** — diakses semua role di `/auth/login`. Validasi email/password, return token, redirect ke `/dashboard`.
4. **Halaman Dashboard** — konten berbeda per role (statistik anak untuk orang tua, konsultasi untuk dokter, KPI konten untuk admin, governance untuk super admin).
5. **Modul Orang Tua** — Children, Stunting Detection, Detection History, Monitoring, Consultation, Food Recommendations, Profile.
6. **Modul Dokter** — Consultation Management, Patients, Monitoring, Foods, Profile.
7. **Modul Admin** — Articles, FAQs, Foods, Children, Reports, Users.
8. **Modul Super Admin** — Users, Roles & Permission, Log System.
9. **Kontrol Akses 403** — screenshot halaman 403 saat akses cross-role.

---

## 8) Template BAB 4.5 Pengujian (contoh tabel siap pakai)

> Semua tabel di bawah memakai format yang sama dengan contoh teman Anda (tabel pengujian `helpdesk`). Sesuaikan nomor tabel dengan penomoran bab Anda.

### 8.1 Pengujian Halaman Register

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Register akun orang tua valid | Buka `/auth/register`, isi form step-1, lanjut step-2 | Nama: Budi; Email: `budi@test.com`; Pass: `password123`; data step-2 lengkap | Akun tersimpan, redirect ke `/auth/login` | Akun tersimpan, redirect ke `/auth/login` | Valid |
| 2 | Register dengan email sudah terdaftar | Isi form register | Email: `anas@example.com` | Pesan error "Email sudah digunakan" | Pesan error muncul | Valid |
| 3 | Register dengan password kurang dari 8 karakter | Isi form register | Pass: `123` | Pesan error validasi password | Pesan error muncul | Valid |
| 4 | Register tanpa mengisi step-2 | Skip step-2 | — | Sistem menahan proses, step-2 wajib | Proses ditahan | Valid |

### 8.2 Pengujian Halaman Login

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Login orang tua valid | Buka `/auth/login`, submit form | `anas@example.com` / `password123` | Redirect ke `/dashboard` (menu orang tua) | Redirect berhasil | Valid |
| 2 | Login dokter valid | Submit form | `dokter@example.com` / `password123` | Redirect ke `/dashboard` (menu dokter) | Redirect berhasil | Valid |
| 3 | Login admin valid | Submit form | `admin@app.test` / `password123` | Redirect ke `/dashboard` (menu admin) | Redirect berhasil | Valid |
| 4 | Login super admin valid | Submit form | `superadmin@app.test` / `password123` | Redirect ke `/dashboard` (menu superadmin) | Redirect berhasil | Valid |
| 5 | Login password salah | Submit form | `admin@app.test` / `salah123` | Pesan "Email atau kata sandi salah" | Pesan muncul | Valid |
| 6 | Login format email salah | Submit form | `adminapp` / `password123` | Pesan "Alamat email tidak valid" | Pesan muncul | Valid |
| 7 | Login akun tidak terdaftar | Submit form | `unknown@app.test` / `secret123` | Pesan "Email atau kata sandi salah" | Pesan muncul | Valid |

### 8.3 Pengujian Dashboard (per role)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Dashboard orang tua menampilkan ringkasan anak | Login sebagai `anas@example.com` | — | Card jumlah anak, grafik pertumbuhan, history terbaru | Ditampilkan | Valid |
| 2 | Dashboard dokter menampilkan statistik konsultasi | Login sebagai `dokter@example.com` | — | Konsultasi pending/ongoing/selesai | Ditampilkan | Valid |
| 3 | Dashboard admin menampilkan statistik konten | Login sebagai `admin@app.test` | — | Total artikel, FAQ, foods, users | Ditampilkan | Valid |
| 4 | Dashboard super admin menampilkan governance | Login sebagai `superadmin@app.test` | — | Statistik users/roles, link log-system | Ditampilkan | Valid |

### 8.4 Pengujian Modul Children (Orang Tua)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Tambah anak baru | Klik "Tambah Anak" | Nama: Arka; JK: L; Tgl lahir: 2023-01-10 | Data anak tersimpan & muncul di list | Berhasil | Valid |
| 2 | Edit data anak | Klik ikon edit | Ubah tinggi lahir | Data ter-update | Berhasil | Valid |
| 3 | Hapus anak | Klik ikon hapus, konfirmasi | — | Data terhapus dari list | Berhasil | Valid |
| 4 | Validasi tanggal lahir di masa depan | Isi tgl lahir > hari ini | Tgl: 2030-01-01 | Pesan error validasi | Pesan muncul | Valid |

### 8.5 Pengujian Deteksi Risiko Stunting

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Deteksi dengan data valid | Pilih anak → isi tinggi | Tinggi: 80 cm; Tgl: hari ini | Status Normal/Berisiko/Stunting + Z-score + saran | Hasil muncul | Valid |
| 2 | Deteksi tanpa memilih anak | Submit form tanpa pilih anak | — | Pesan "Anak wajib dipilih" | Pesan muncul | Valid |
| 3 | Deteksi dengan tinggi tidak masuk akal | Isi tinggi 500 cm | 500 | Pesan validasi range | Pesan muncul | Valid |
| 4 | Simpan hasil ke riwayat | Setelah deteksi sukses | — | Hasil muncul di `/detection-history` | Muncul | Valid |

### 8.6 Pengujian Monitoring Pertumbuhan

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Tampilkan grafik TB/U & BB/U | Pilih anak | — | Grafik + kurva WHO | Ditampilkan | Valid |
| 2 | Filter rentang waktu | Pilih 3 bulan | — | Grafik ikut berubah | Berubah | Valid |
| 3 | Tabel riwayat pengukuran | Scroll ke tabel | — | List riwayat terurut tanggal | Ditampilkan | Valid |

### 8.7 Pengujian Konsultasi (Orang Tua ↔ Dokter)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Orang tua mulai konsultasi baru | Klik "Mulai Konsultasi" | Pesan: "Anak saya pendek" | Room chat terbuat, pesan terkirim | Terkirim | Valid |
| 2 | Dokter merespons konsultasi | Login dokter → `/doctor/consultation` | Balasan: "Silakan kirim grafik" | Pesan muncul di chat orang tua | Muncul | Valid |
| 3 | Dokter menandai selesai | Klik "Selesai" | — | Status konsultasi = `closed` | Terupdate | Valid |

### 8.8 Pengujian Articles (Admin)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Tambah artikel | Klik "Tambah Artikel" | Judul: Gizi Balita; konten: Lorem | Artikel tersimpan | Tersimpan | Valid |
| 2 | Edit artikel | Klik edit | Ubah judul | Artikel ter-update | Terupdate | Valid |
| 3 | Hapus artikel | Klik hapus, konfirmasi | — | Artikel terhapus | Terhapus | Valid |

### 8.9 Pengujian FAQs (Admin)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Tambah FAQ | Klik "Tambah FAQ" | Pertanyaan + jawaban | FAQ tersimpan | Tersimpan | Valid |
| 2 | Edit FAQ | Klik edit | Ubah jawaban | FAQ ter-update | Terupdate | Valid |
| 3 | Hapus FAQ | Klik hapus, konfirmasi | — | FAQ terhapus | Terhapus | Valid |

### 8.10 Pengujian Foods (Admin / Dokter)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Tambah makanan (admin) | Login admin → `/foods` → tambah | Nama: Bubur Ayam; kandungan gizi | Data tersimpan | Tersimpan | Valid |
| 2 | Tambah makanan (dokter) | Login dokter → `/doctor/foods` → tambah | Nama: Telur Rebus | Data tersimpan | Tersimpan | Valid |
| 3 | Edit makanan | Klik edit | Ubah nama | Data ter-update | Terupdate | Valid |
| 4 | Hapus makanan (admin) | Klik hapus | — | Data terhapus | Terhapus | Valid |

### 8.11 Pengujian Reports (Admin)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Filter laporan | Pilih rentang tanggal | Jan–Mar 2026 | Statistik ikut berubah | Berubah | Valid |
| 2 | Export PDF | Klik "PDF" | — | File PDF ter-download | Ter-download | Valid |
| 3 | Export CSV | Klik "Excel (CSV)" | — | File CSV ter-download | Ter-download | Valid |

### 8.12 Pengujian Manajemen Users (Admin / Super Admin)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Tambah user baru | Klik "Tambah Pengguna" | Nama: Tito; email: `tito@app.test`; role: admin | User tersimpan | Tersimpan | Valid |
| 2 | Edit user | Klik edit | Ubah role menjadi dokter | Role ter-update | Terupdate | Valid |
| 3 | Hapus user | Klik hapus, konfirmasi | — | User terhapus | Terhapus | Valid |
| 4 | Cari user | Ketik di kolom cari | `admin` | List ter-filter | Terfilter | Valid |

### 8.13 Pengujian Roles & Permission (Super Admin)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Tambah role | Klik "Tambah Role" | Nama: `kader`; pilih permission `dashboard-read` | Role tersimpan | Tersimpan | Valid |
| 2 | Edit permission role dokter | Pilih role dokter → centang `monitoring-read` | — | Permission ter-update | Terupdate | Valid |
| 3 | Hapus role | Klik hapus (role tanpa user aktif) | — | Role terhapus | Terhapus | Valid |

### 8.14 Pengujian Log System (Super Admin)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Tampilkan log sistem | Buka `/log-system` | — | List log muncul | Muncul | Valid |
| 2 | Filter log | Pilih tanggal / user | — | Log ter-filter | Terfilter | Valid |

### 8.15 Pengujian Kontrol Akses 403 (Cross-Role)

| No | Deskripsi | Prosedur Pengujian | Masukan | Keluaran Diharapkan | Hasil Didapatkan | Kesimpulan |
|---|---|---|---|---|---|---|
| 1 | Orang tua akses halaman admin users | Login `anas@example.com`, buka `/users` | — | Halaman 403 | 403 muncul | Valid |
| 2 | Dokter akses halaman roles | Login dokter, buka `/roles` | — | Halaman 403 | 403 muncul | Valid |
| 3 | Admin akses log-system | Login admin, buka `/log-system` | — | Halaman 403 | 403 muncul | Valid |
| 4 | Akses API tanpa token | Hit endpoint `/api/users` tanpa Bearer | — | Response 401 Unauthorized | 401 muncul | Valid |
| 5 | Akses API dengan role tidak berwenang | Login orang tua, hit `POST /api/articles` | Payload artikel | Response 403 Forbidden | 403 muncul | Valid |

---

## 9) Kesimpulan Pengujian (template paragraf)

> Berdasarkan hasil pengujian yang dilakukan menggunakan metode **black box testing** terhadap seluruh modul (autentikasi, dashboard, children, stunting detection, monitoring, consultation, articles, FAQ, foods, reports, users management, roles & permission, log system, serta kontrol akses 403), sistem **Deteksi dan Pemantauan Risiko Stunting** telah berjalan sesuai kebutuhan fungsional. Setiap role hanya dapat mengakses fitur yang sesuai dengan permission-nya, dan seluruh percobaan akses ilegal berhasil ditolak dengan respons 403 Forbidden.

---

## 10) Checklist Eksekusi Cepat (Implementasi + Uji)

- [ ] Start ML Flask API (`ml-stunting-detection`) pada port default.
- [ ] Start backend Laravel (`php artisan serve` → 8000).
- [ ] Start FE React (`npm run dev` → 5173).
- [ ] Uji redirect landing `http://localhost:8000/` → FE `http://localhost:5173/auth/login`.
- [ ] Uji register orang tua step-1 & step-2 dari landing.
- [ ] Login untuk 4 akun role (orang tua, dokter, admin, super admin) dan verifikasi sidebar.
- [ ] Uji CRUD + aksi fungsional per modul mengikuti tabel bagian 8.
- [ ] Uji skenario 403 di tabel 8.15.
- [ ] Screenshot tiap halaman + tabel hasil untuk dilampirkan ke BAB 4.

---

*Dokumen ini otomatis menjadi sumber kebenaran untuk BAB 4.4 dan 4.5. Bila ada perubahan role/permission di DB, update bagian 2 & 3 terlebih dahulu supaya pengujian tetap selaras.*
