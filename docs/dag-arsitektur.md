# Arsitektur DAG

FlowForge menggunakan konsep Directed Acyclic Graph (DAG) sebagai representasi workflow.

---

# Apa itu DAG?

DAG (Directed Acyclic Graph) adalah kumpulan node yang saling terhubung menggunakan edge dan tidak memiliki cycle.

Contoh:

```text
A
│
├── B
│
├── C
│
└── D
```

Node B, C, dan D hanya dapat berjalan setelah A selesai.

---

# Komponen DAG

## Node

Node merepresentasikan satu pekerjaan atau aktivitas.

Contoh:

- Input Data
- Validasi Data
- Kirim Email
- Generate Report

---

## Edge

Edge merepresentasikan dependency antar node.

Contoh:

```text
A -> B
```

Artinya:

Node B hanya dapat dijalankan setelah Node A selesai.

---

# Struktur Workflow

Contoh sederhana:

```json
{
  "nodes": [
    {
      "id": "prepare_data"
    },
    {
      "id": "validate_data"
    },
    {
      "id": "send_email"
    }
  ],
  "edges": [
    {
      "from": "prepare_data",
      "to": "validate_data"
    },
    {
      "from": "validate_data",
      "to": "send_email"
    }
  ]
}
```

---

# Validasi Workflow

Sebelum workflow disimpan, sistem melakukan validasi:

## Validasi Referensi Node

Memastikan seluruh edge mengarah ke node yang valid.

Contoh tidak valid:

```text
A -> B
B -> X
```

Karena node X tidak ada.

---

## Deteksi Cycle

Contoh tidak valid:

```text
A -> B
B -> C
C -> A
```

Karena membentuk loop.

FlowForge menggunakan DFS (Depth First Search) untuk mendeteksi cycle.

---

# Proses Eksekusi

## 1. Ambil Start Node

Start node adalah node yang tidak memiliki incoming edge.

Contoh:

```text
A -> B
A -> C
```

Start node:

```text
A
```

---

## 2. Dispatch Queue Job

Setiap start node akan mengirimkan:

```php
ExecuteNodeJob
```

ke Laravel Queue.

---

## 3. Eksekusi Node

Node dieksekusi menggunakan:

```php
NodeExecutorServices
```

---

## 4. Evaluasi Dependency

Setelah node selesai:

```php
DagHelper::isNodeReady()
```

digunakan untuk mengecek apakah node berikutnya sudah memenuhi seluruh dependency.

---

## 5. Dispatch Next Node

Jika seluruh parent node berhasil:

```text
success
```

maka node berikutnya akan dikirim ke queue.

---

# Parallel Execution

FlowForge mendukung eksekusi paralel.

Contoh:

```text
A
├── B
├── C
└── D
```

Setelah A selesai:

- B dapat berjalan
- C dapat berjalan
- D dapat berjalan

secara bersamaan melalui queue worker.

---

# Retry Mechanism

Setiap node memiliki konfigurasi:

```php
public $tries = 3;
public $backoff = [1,2,4];
```

Jika node gagal:

- Retry ke-1 : 1 detik
- Retry ke-2 : 2 detik
- Retry ke-3 : 4 detik

---

# Workflow Completion

Workflow dianggap selesai apabila:

- Seluruh node berhasil dijalankan

atau

- Salah satu node gagal dan workflow ditandai failed.
