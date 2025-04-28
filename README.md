Project Management System
Deskripsi Proyek
Project Management System adalah aplikasi berbasis Laravel yang dirancang untuk mengelola proyek, tugas, dan komentar dengan fitur autentikasi, manajemen role dan pengguna, soft delete, audit trail, serta ekspor/impor data dalam format Excel. Aplikasi ini dibangun untuk memenuhi kebutuhan coding test dengan empat topik utama:

Laravel Authentication: Landing page publik, dashboard terautentikasi, dan manajemen role/pengguna dengan akses terbatas.
Laravel Basic CRUD & Relationship: CRUD untuk proyek, tugas, dan komentar dengan relasi, soft delete, dan upload file PDF.
Laravel Audits: Pelacakan perubahan data menggunakan audit trail.
Excel Export & Import: Ekspor/impor data dengan kolom dinamis menggunakan queue untuk pemrosesan di latar belakang.
Aplikasi ini menggunakan Laravel 10.x, dilengkapi dengan SB Admin 2 untuk antarmuka, dan mendukung fitur seperti select2, DataTables, dan queue berbasis database.

Fitur
Autentikasi:
Landing page publik (/).
Dashboard hanya untuk pengguna terautentikasi (/dashboard).
Manajemen role (/roles) untuk semua pengguna terautentikasi (index/show) dan Administrator (create/edit/delete).
Manajemen pengguna (/users) hanya untuk Administrator.
CRUD & Relasi:
Tiga resource: Projects, Tasks, Comments dengan relasi (Project → Tasks → Comments, User → Role).
Field wajib: UUID, datetime, boolean, JSON (perlu konfirmasi untuk boolean/JSON).
Soft delete dengan fitur restore.
Upload file PDF (100–500 KB) untuk proyek/tugas (perlu konfirmasi implementasi).
Select2 untuk memilih role, proyek, atau pengguna.
Pencarian, filter, dan sorting (parsial, perlu konfirmasi filter kustom).
Audit Trail:
Pelacakan perubahan data (create, update, delete) pada semua resource menggunakan owen-it/laravel-auditing.
Tampilan audit trail di halaman detail (perlu konfirmasi implementasi view).
Excel Export & Import:
Ekspor data dengan kolom dinamis (misalnya, id, name, email).
Impor data dari file Excel dengan validasi.
Pemrosesan di latar belakang menggunakan queue (ExportExcel, ImportExcel).
Halaman /exports untuk mengunduh file yang diekspor.
Antarmuka:
Template SB Admin 2 dengan DataTables untuk tabel dan Select2 untuk dropdown.
Modal untuk ekspor/impor dan pesan sukses/error.
Persyaratan
PHP ^8.1
Composer ^2.0
MySQL atau database lain yang didukung Laravel
Node.js dan NPM (untuk aset frontend)
Dependensi utama:
laravel/framework: ^10.0
maatwebsite/excel: ^3.1
owen-it/laravel-auditing: ^13.0
spatie/laravel-permission (opsional, jika digunakan untuk middleware role)
Server lokal (misalnya, Laravel Artisan atau Valet) atau server produksi
Redis atau database untuk queue (konfigurasi QUEUE_CONNECTION=database)
Instalasi
Clone Repository:
bash

Salin
git clone <repository-url>
cd project-management-system
Instal Dependensi:
bash

Salin
composer install
npm install
npm run build
Konfigurasi Lingkungan:
Salin file .env.example ke .env:
bash

Salin
cp .env.example .env
Edit .env untuk konfigurasi database dan queue:
env

Salin
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_management
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database
Generate key aplikasi:
bash

Salin
php artisan key:generate
Jalankan Migrasi dan Seeder:
bash

Salin
php artisan migrate --seed
Ini akan membuat tabel users, roles, projects, tasks, comments, audits, jobs, dan exported_files.
RoleSeeder mengisi tabel roles dengan Administrator, Management, dan User.
Buat Storage Link:
bash

Salin
php artisan storage:link
Ini memungkinkan akses ke file di storage/app/public (misalnya, file Excel atau PDF).
Jalankan Queue Worker:
bash

Salin
php artisan queue:work
Biarkan berjalan untuk memproses ekspor/impor Excel di latar belakang.
Untuk produksi, gunakan Supervisor untuk mengelola queue.
Jalankan Server:
bash

Salin
php artisan serve
Akses aplikasi di http://localhost:8000.
Struktur Aplikasi
text

Salin
project-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── UserController.php
│   │   │   │   ├── RoleController.php
│   │   │   │   ├── ExportController.php
│   │   │   ├── Auth/
│   │   │   │   ├── AuthController.php
│   │   │   ├── Project/
│   │   │   │   ├── ProjectController.php
│   │   │   │   ├── TaskController.php
│   │   │   │   ├── CommentController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── LandingController.php
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php
│   ├── Jobs/
│   │   ├── ExportExcel.php
│   │   ├── ImportExcel.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Project.php
│   │   ├── Task.php
│   │   ├── Comment.php
│   │   ├── ExportedFile.php
│   ├── Exports/
│   │   ├── UsersExport.php
│   │   ├── RolesExport.php
│   ├── Imports/
│   │   ├── UsersImport.php
│   │   ├── RolesImport.php
├── database/
│   ├── migrations/
│   │   ├── 2025_04_28_000001_create_roles_table.php
│   │   ├── 2025_04_28_000002_add_soft_deletes_to_roles_table.php
│   │   ├── ... (migrasi untuk users, projects, tasks, comments, exported_files)
│   ├── seeders/
│   │   ├── RoleSeeder.php
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── users/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   ├── edit.blade.php
│   │   │   │   ├── show.blade.php
│   │   │   ├── roles/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   ├── edit.blade.php
│   │   │   │   ├── show.blade.php
│   │   │   ├── exports/
│   │   │   │   ├── index.blade.php
│   │   ├── auth/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   ├── landing.blade.php
│   │   ├── dashboard.blade.php
├── routes/
│   ├── web.php
├── public/
│   ├── storage/ (symlink ke storage/app/public)
Cara Penggunaan
Akses Publik:
Buka http://localhost:8000/ untuk melihat landing page.
Login:
Buka /login dan gunakan kredensial:
Administrator: admin@example.com / password123
Management: manager@example.com / password123
User: user@example.com / password123
Manajemen Role:
Buka /roles untuk melihat daftar role (semua pengguna terautentikasi).
Administrator dapat membuat, mengedit, menghapus (soft delete), dan memulihkan role.
Manajemen Pengguna:
Buka /users untuk mengelola pengguna (hanya Administrator).
Gunakan select2 untuk memilih role saat membuat/mengedit pengguna.
Manajemen Proyek, Tugas, Komentar:
Buka /projects, /tasks, /comments untuk CRUD.
Unggah file PDF (100–500 KB) saat membuat proyek/tugas (jika diimplementasikan).
Gunakan filter/pencarian untuk mencari data.
Ekspor/Impor Excel:
Klik tombol "Export" di halaman index untuk memilih kolom dan ekspor data.
Klik tombol "Import" untuk mengunggah file Excel.
Buka /exports untuk mengunduh file yang diekspor.
Audit Trail:
Buka halaman detail (show) untuk melihat audit trail perubahan data.
Panduan Pengujian (QA Testing)
Berikut adalah data dan skenario untuk menguji aplikasi secara menyeluruh:

Data Pengujian
Tabel roles:
php

Salin
Role::insert([
    ['name' => 'Administrator', 'guard_name' => 'web'],
    ['name' => 'Management', 'guard_name' => 'web'],
    ['name' => 'User', 'guard_name' => 'web'],
    ['name' => 'Tester', 'guard_name' => 'web'],
    ['name' => 'Guest', 'guard_name' => 'web', 'deleted_at' => now()],
]);
Tabel users:
php

Salin
User::create([
    'uuid' => Str::uuid(),
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => Hash::make('password123'),
    'role_id' => 1,
]);
User::create([
    'uuid' => Str::uuid(),
    'name' => 'Manager User',
    'email' => 'manager@example.com',
    'password' => Hash::make('password123'),
    'role_id' => 2,
]);
User::create([
    'uuid' => Str::uuid(),
    'name' => 'Regular User',
    'email' => 'user@example.com',
    'password' => Hash::make('password123'),
    'role_id' => 3,
]);
Tabel projects:
php

Salin
Project::create([
    'uuid' => Str::uuid(),
    'name' => 'Website Redesign',
    'is_active' => true,
    'metadata' => json_encode(['client' => 'ABC Corp', 'budget' => 5000]),
    'user_id' => 1,
    'file_path' => 'projects/sample.pdf',
]);
Project::create([
    'uuid' => Str::uuid(),
    'name' => 'Mobile App Development',
    'is_active' => false,
    'metadata' => json_encode(['client' => 'XYZ Inc', 'budget' => 10000]),
    'user_id' => 2,
    'file_path' => 'projects/sample2.pdf',
]);
Tabel tasks:
php

Salin
Task::create([
    'uuid' => Str::uuid(),
    'title' => 'Design Homepage',
    'is_completed' => false,
    'details' => json_encode(['priority' => 'high', 'deadline' => '2025-05-10']),
    'project_id' => 1,
    'user_id' => 3,
]);
Task::create([
    'uuid' => Str::uuid(),
    'title' => 'Develop API',
    'is_completed' => true,
    'details' => json_encode(['priority' => 'medium', 'deadline' => '2025-05-15']),
    'project_id' => 1,
    'user_id' => 2,
]);
Tabel comments:
php

Salin
Comment::create([
    'uuid' => Str::uuid(),
    'content' => 'Need to revise the design.',
    'is_approved' => false,
    'attributes' => json_encode(['type' => 'feedback']),
    'task_id' => 1,
    'user_id' => 3,
]);
Comment::create([
    'uuid' => Str::uuid(),
    'content' => 'API documentation completed.',
    'is_approved' => true,
    'attributes' => json_encode(['type' => 'update']),
    'task_id' => 2,
    'user_id' => 2,
]);
File PDF:
sample.pdf (200 KB, valid).
large.pdf (600 KB, untuk uji error ukuran).
non_pdf.txt (untuk uji error tipe file).
Skenario Pengujian
Autentikasi:
Akses / tanpa login (harus berhasil).
Akses /dashboard tanpa login (harus redirect ke /login).
Login sebagai Administrator, Management, User, uji akses ke /roles dan /users (error 403 untuk non-Administrator).
CRUD & Relasi:
Buat, edit, hapus (soft delete), dan restore data di users, roles, projects, tasks, comments.
Pastikan relasi ditampilkan di front-end (misalnya, nama role di users.index).
Soft Delete:
Hapus data dan periksa status Deleted di view.
Restore data dan pastikan status kembali ke Active.
Upload File:
Unggah PDF valid dan tidak valid di form proyek/tugas (jika ada).
Periksa validasi error untuk ukuran (100–500 KB) dan tipe file.
Select2:
Uji dropdown role di users.create dan proyek/pengguna di tasks.create.
Pencarian/Filter/Sorting:
Cari pengguna berdasarkan nama/email, filter berdasarkan role.
Uji sorting di DataTables atau query kustom.
Audit Trail:
Periksa audit trail di halaman detail (users.show, roles.show, dll.).
Pastikan data historis tidak berubah saat data induk diupdate.
Ekspor/Impor Excel:
Ekspor data dengan kolom berbeda, unduh dari /exports.
Impor data dengan file Excel, pastikan data baru muncul.
Periksa tabel jobs dan failed_jobs untuk memastikan queue berjalan.
Performa:
Uji ekspor/impor dengan 100+ data.
Pastikan queue tidak error.
Keamanan:
Pastikan non-Administrator tidak bisa akses rute terbatas (/users, /roles/create).
Catatan Pengembang
Poin yang Perlu Dikonfirmasi:
Implementasi upload file PDF (Topik 2.v) belum dikonfirmasi.
Kolom boolean dan JSON di tabel projects, tasks, comments perlu diverifikasi.
Pencarian/filter/sorting kustom (Topik 2.vii) perlu ditambahkan jika hanya mengandalkan DataTables.
Tampilan audit trail di view (Topik 3.b) perlu ditambahkan.
Peningkatan Potensial:
Tambahkan notifikasi real-time untuk ekspor/impor menggunakan Laravel Echo.
Tambahkan job untuk menghapus file ekspor lama (misalnya, setelah 7 hari).
Implementasikan filter kustom dan sorting di semua halaman index.
Kontribusi
Fork repository ini.
Buat branch baru (git checkout -b feature/nama-fitur).
Commit perubahan (git commit -m 'Menambahkan fitur X').
Push ke branch (git push origin feature/nama-fitur).
Buat Pull Request.
Lisensi
Proyek ini dilisensikan di bawah .
