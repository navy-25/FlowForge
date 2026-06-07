# FlowForge

FlowForge adalah Workflow Engine berbasis Laravel yang digunakan untuk membuat, memvalidasi, dan mengeksekusi workflow dalam bentuk Directed Acyclic Graph (DAG).

Workflow disusun dari kumpulan node dan dependency (edge) yang menentukan urutan eksekusi proses. Engine mendukung eksekusi asynchronous menggunakan Laravel Queue sehingga workflow dapat berjalan secara paralel sesuai dependency yang telah ditentukan.

## Fitur Utama

### Workflow Management
- Membuat workflow berbasis DAG
- Menyimpan versi workflow
- Mendukung trigger manual dan cron

### Workflow Validation
- Validasi struktur workflow
- Validasi referensi node
- Deteksi cycle (circular dependency)

### Workflow Execution
- Sequential execution
- Parallel execution
- Dependency-based execution
- Context passing antar node

### Queue Processing
- Background processing menggunakan Laravel Queue
- Retry mechanism
- Exponential backoff
- Timeout handling

### Monitoring
- Monitoring workflow run
- Monitoring setiap node execution
- Status tracking
- Error logging

---

## Teknologi

- PHP 8+
- Laravel 11
- MySQL
- Laravel Queue

---

## Konsep Workflow

Workflow direpresentasikan dalam bentuk DAG (Directed Acyclic Graph).

Contoh:

Start
├── Validate Data
├── Generate Report
└── Send Email

Setiap node hanya dapat dieksekusi apabila seluruh parent node telah selesai dieksekusi dengan status success.

---

## Struktur Utama

### Workflow
Menyimpan definisi workflow.

### Workflow Run
Menyimpan riwayat eksekusi workflow.

### Workflow Run Step
Menyimpan riwayat eksekusi setiap node.

---

## Dokumentasi

- docs/starter.md
- docs/dag-arsitektur.md
- docs/db-arsitektur.md

---

## Author

FlowForge Technical Test Project
