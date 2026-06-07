# Getting Started

Dokumen ini menjelaskan cara menjalankan FlowForge di lingkungan lokal.

---

# Requirement

- PHP 8.2+
- Composer
- MySQL
- Laravel 11

---

# 1. Clone Repository

```bash
git clone <repository-url>
cd flowforge
```

---

# 2. Install Dependency

```bash
composer install
```

---

# 3. Copy Environment

```bash
cp .env.example .env
```

atau Windows:

```bash
copy .env.example .env
```

---

# 4. Generate Application Key

```bash
php artisan key:generate
```

---

# 5. Konfigurasi Database

Edit file `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flowforge
DB_USERNAME=root
DB_PASSWORD=
```

---

# 6. Jalankan Migration

```bash
php artisan migrate
```

---

# 7. Jalankan Web Server

```bash
php artisan serve
```

Aplikasi akan berjalan pada:

```text
http://127.0.0.1:8000
```

---

# 8. Jalankan Queue Worker

FlowForge menggunakan Laravel Queue untuk mengeksekusi node workflow secara asynchronous.

Buka terminal baru:

```bash
php artisan queue:work
```

Queue worker wajib berjalan agar workflow dapat diproses.

---

# Menjalankan Workflow

## Membuat Workflow

1. Login ke aplikasi
2. Buka halaman Workflow
3. Buat workflow baru
4. Simpan workflow

---

## Menjalankan Workflow

Workflow dapat dijalankan melalui:

- UI
- API Endpoint

Saat workflow dijalankan:

1. WorkflowRun dibuat
2. Start Node dicari
3. Job ExecuteNodeJob dikirim ke queue
4. Queue worker mengeksekusi node
5. Node berikutnya dijalankan apabila dependency terpenuhi

---

# Monitoring

Monitoring tersedia pada menu:

- Workflow History
- Workflow Monitoring

Informasi yang dapat dilihat:

- Status workflow
- Status node
- Error node
- Output node
- Execution time

---

# Troubleshooting

## Workflow tidak berjalan

Pastikan queue worker aktif:

```bash
php artisan queue:work
```

---

## Job tidak diproses

Periksa konfigurasi queue pada file:

```env
QUEUE_CONNECTION=database
```

Pastikan tabel jobs sudah tersedia:

```bash
php artisan migrate
```

---

## Membersihkan Queue

```bash
php artisan queue:clear
```

---

## Restart Queue

```bash
php artisan queue:restart
```
