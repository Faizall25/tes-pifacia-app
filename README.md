# 📖 Project Management System

## Deskripsi Proyek
**Project Management System** adalah aplikasi berbasis Laravel 12.x yang dirancang untuk mengelola **Proyek**, **Tugas**, dan **Komentar** dengan fitur:
- Autentikasi
- Manajemen Role & User
- Soft Deletes
- Audit Trail
- Export/Import Excel berbasis Queue

Dibangun untuk memenuhi coding test dengan fokus empat topik utama:
- **Laravel Authentication**: Landing Page publik, Dashboard setelah login, Manajemen Role/User.
- **Laravel Basic CRUD & Relationship**: CRUD Projects, Tasks, Comments dengan relasi, Soft Delete, Upload File PDF.
- **Laravel Audits**: Mencatat perubahan data dengan audit trail.
- **Excel Export & Import**: Proses ekspor/impor dinamis dengan background job (queue).

Aplikasi ini menggunakan **SB Admin 2** untuk antarmuka UI dan integrasi **Select2**, **DataTables**, dan **Laravel Queue**.

---

## ✨ Fitur

### 1. Autentikasi
- Landing page publik (`/`).
- Dashboard hanya untuk pengguna terautentikasi (`/dashboard`).
- Manajemen Role (`/roles`) terbuka untuk semua login, CRUD Role hanya untuk Administrator.
- Manajemen User (`/users`) hanya untuk Administrator.

### 2. CRUD & Relasi
- Resources: **Projects**, **Tasks**, **Comments**.
- Relasi: Project ➔ Tasks ➔ Comments | User ➔ Role.
- Field wajib: UUID, datetime, boolean, JSON.
- Soft Delete + Restore data.
- Upload File PDF (100–500 KB).
- Select2 Dropdown untuk memilih Role, Project, User.
- Pencarian, Filtering, Sorting (partial dengan DataTables).

### 3. Audit Trail
- Tracking perubahan **create**, **update**, **delete** semua data.
- Menggunakan package `owen-it/laravel-auditing`.
- Tampil di halaman detail masing-masing entitas.

### 4. Excel Export & Import
- Ekspor data dinamis (pilih kolom).
- Import data validasi dari file Excel.
- Proses berjalan di background menggunakan Queue.

### 5. Antarmuka
- Tabel responsif dengan **DataTables**.
- Dropdown canggih dengan **Select2**.
- Modal untuk aksi Export/Import.

---

## ⚙️ Persyaratan
- PHP ≥ 8.2
- Composer ≥ 2.0
- MySQL (atau database support Laravel)
- Node.js & NPM
- Redis/Database untuk queue (set `QUEUE_CONNECTION=database`)

**Package utama:**
- `laravel/framework: ^12.0`
- `maatwebsite/excel: ^3.1`
- `owen-it/laravel-auditing: ^13.0`
- `spatie/laravel-permission` (optional)

---

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd project-management-system
```

### 2. Install Dependency
```bash
composer install
npm install
npm run build
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
```
Lalu edit `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_management
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database
```

Generate Key:
```bash
php artisan key:generate
```

### 4. Migrasi dan Seeder
```bash
php artisan migrate --seed
```

### 5. Buat Storage Link
```bash
php artisan storage:link
```

### 6. Jalankan Queue Worker
```bash
php artisan queue:work
```
(Opsional: Untuk production, gunakan Supervisor.)

### 7. Jalankan Server
```bash
php artisan serve
```
Akses aplikasi di [http://localhost:8000](http://localhost:8000).

---

## 👨‍💻 Cara Penggunaan

- **Landing Page:**  
  ➔ Akses di `/`.

- **Login:**  
  ➔ `/login`  
  Gunakan akun:
  - Administrator: `admin@example.com / password123`
  - Management: `manager@example.com / password123`
  - User: `user@example.com / password123`

- **Manajemen Role:**  
  ➔ `/roles`

- **Manajemen User:**  
  ➔ `/users`

- **CRUD Projects, Tasks, Comments:**  
  ➔ `/projects`, `/tasks`, `/comments`

- **Export & Import Excel:**  
  ➔ Klik tombol Export/Import di halaman terkait.

- **Audit Trail:**  
  ➔ Lihat di halaman detail entitas (Show).

---

## 🧪 Panduan Pengujian (QA Testing)

### Data Seed:
- Roles: Administrator, Management, User, Tester, Guest (soft deleted).
- Users: Admin User, Manager User, Regular User.
- Projects: Website Redesign, Mobile App Development.
- Tasks: Design Homepage, Develop API.
- Comments: Need revision, API documentation done.

### Skenario Test:
- Cek akses autentikasi
- CRUD data
- Upload file PDF valid/invalid
- Import/Export data Excel
- Lihat audit trail
- Test Queue berjalan saat export/import
- Cek validasi field

---

## 🚀 Peningkatan Potensial
- Notifikasi real-time (Laravel Echo + Pusher).
- Scheduled Job untuk auto-delete file eksport lama.
- Filter & Sorting kustom tambahan di semua tabel.

---

## 🤝 Kontribusi
1. Fork repository
2. Buat branch (`git checkout -b feature/nama-fitur`)
3. Commit perubahan (`git commit -m 'Menambahkan fitur X'`)
4. Push branch (`git push origin feature/nama-fitur`)
5. Buat Pull Request.

---

## 📜 Lisensi
Lisensi proyek ini akan ditentukan.

---

# 📋 Catatan
> Untuk hasil maksimal dalam coding test, pastikan semua fitur di atas diuji dan berjalan sesuai requirement.
