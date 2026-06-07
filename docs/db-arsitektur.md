# Arsitektur Database

Dokumen ini menjelaskan struktur database utama pada FlowForge.

---

# Entity Relationship

```text
users
  │
  └── workflows
          │
          └── workflow_runs
                    │
                    └── workflow_run_steps
```

---

# users

Menyimpan data pengguna sistem.

| Kolom | Tipe |
|---------|---------|
| id | bigint |
| tenant_id | bigint |
| name | varchar |
| email | varchar |
| password | varchar |
| role | varchar |

---

# tenants

Menyimpan informasi tenant.

| Kolom | Tipe |
|---------|---------|
| id | bigint |
| name | varchar |
| created_at | timestamp |
| updated_at | timestamp |

---

# workflows

Menyimpan definisi workflow.

| Kolom | Tipe |
|---------|---------|
| id | bigint |
| user_id | bigint |
| name | varchar |
| version | varchar |
| trigger_type | enum |
| cron_expression | varchar |
| definition | json |
| created_at | timestamp |
| updated_at | timestamp |

---

## definition

Berisi struktur DAG.

Contoh:

```json
{
  "nodes": [],
  "edges": []
}
```

---

# workflow_runs

Menyimpan histori eksekusi workflow.

| Kolom | Tipe |
|---------|---------|
| id | bigint |
| workflow_id | bigint |
| status | varchar |
| started_at | timestamp |
| finished_at | timestamp |
| created_at | timestamp |
| updated_at | timestamp |

---

## Status Workflow

```text
pending
running
completed
failed
cancelled
```

---

# workflow_run_steps

Menyimpan histori eksekusi setiap node.

| Kolom | Tipe |
|---------|---------|
| id | bigint |
| workflow_run_id | bigint |
| node_id | varchar |
| status | varchar |
| output | json |
| context | json |
| error | text |
| created_at | timestamp |
| updated_at | timestamp |

---

## Status Step

```text
pending
queued
running
success
failed
retrying
```

---

# Relasi

## Workflow

```text
Workflow
  hasMany
WorkflowRun
```

---

## Workflow Run

```text
WorkflowRun
  belongsTo
Workflow
```

```text
WorkflowRun
  hasMany
WorkflowRunSteps
```

---

## Workflow Run Step

```text
WorkflowRunStep
  belongsTo
WorkflowRun
```

---

# Audit Execution

Setiap kali workflow dijalankan:

1. Record baru dibuat pada workflow_runs
2. Node yang dieksekusi dicatat pada workflow_run_steps
3. Output node disimpan pada kolom output
4. Context diteruskan melalui kolom context
5. Error disimpan pada kolom error

Dengan struktur ini seluruh proses workflow dapat ditelusuri kembali untuk kebutuhan monitoring dan debugging.
