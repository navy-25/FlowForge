## SOW di susun berdasarkan Core Requirements yang diberikan pada proses Technical Test
 
### SOW Checklist:
A. Workflow
| ID    | Modul           | Fitur                | Deskripsi                                                    | Done  |  
| ----- | --------------- | -------------------- | ------------------------------------------------------------ | ----- |   
| A-001 | Workflow Engine | Workflow Definition  | Membuat workflow dalam bentuk DAG (node dan dependency)      | ✅   |
| A-002 | Workflow Engine | Workflow Validation  | Validasi struktur workflow dan memastikan tidak ada cycle    | ✅   |
| A-003 | Workflow Engine | Execution Order      | Menentukan urutan eksekusi menggunakan topological sort      | ✅   |
| A-004 | Workflow Engine | Sequential Execution | Menjalankan step berdasarkan dependency                      | ✅   |
| A-005 | Workflow Engine | Parallel Execution   | Menjalankan step yang tidak saling bergantung secara paralel | ✅   |
| A-006 | Workflow Engine | Retry Mechanism      | Retry step yang gagal dengan konfigurasi jumlah retry        | ✅   |
| A-007 | Workflow Engine | Exponential Backoff  | Delay retry menggunakan exponential backoff                  | ✅   |
| A-008 | Workflow Engine | Workflow Timeout     | Menghentikan workflow jika melebihi batas waktu              | ✅   |
| A-009 | Workflow Engine | Execution Log        | Menyimpan status dan hasil eksekusi setiap step              | ✅   |

B. Multi-Tenant API Layer
| ID    | Modul          | Fitur                  | Deskripsi                                  | Done  |
| ----- | -------------- | ---------------------- | ------------------------------------------ | ----- | 
| B-001 | Authentication | Login JWT              | Login dan mendapatkan access token         | ❌   |
| B-002 | Authentication | Role Management        | Role Admin, Editor, Viewer                 | ❌   |
| B-003 | Tenant         | Tenant Isolation       | Memastikan data tenant terpisah            | ✅   |
| B-004 | Workflow API   | Create Workflow        | Membuat workflow                           | ✅   |
| B-005 | Workflow API   | Update Workflow        | Mengubah workflow                          | ❌   |
| B-006 | Workflow API   | Delete Workflow        | Menghapus workflow                         | ❌   |
| B-007 | Workflow API   | Workflow Detail        | Melihat detail workflow                    | ❌   |
| B-008 | Workflow API   | Workflow List          | Menampilkan daftar workflow                | ✅   |
| B-009 | Workflow API   | Pagination & Filtering | Pagination dan pencarian data              | ✅   |
| B-010 | Versioning     | Workflow Versioning    | Menyimpan riwayat perubahan workflow       | ✅   |
| B-011 | Versioning     | Rollback Workflow      | Mengembalikan workflow ke versi sebelumnya | ❌   |
| B-012 | Trigger        | Manual Trigger         | Menjalankan workflow secara manual         | ✅   |
| B-013 | Trigger        | Scheduled Trigger      | Menjalankan workflow menggunakan cron      | ❌   |
| B-014 | Trigger        | Webhook Trigger        | Menjalankan workflow melalui webhook       | ❌   |
| B-015 | Security       | Input Validation       | Validasi request API                       | ✅   |
| B-016 | Security       | Rate Limiting          | Membatasi jumlah request API               | ✅   |

C. Real-Time Monitoring Dashboard
| ID    | Modul     | Fitur                  | Deskripsi                                   | Done  |
| ----- | --------- | ---------------------- | ------------------------------------------- | ----- | 
| C-001 | Dashboard | Workflow List          | Menampilkan daftar workflow                 | ✅   |
| C-002 | Dashboard | DAG Visualization      | Menampilkan diagram workflow                | ❌   |
| C-003 | Dashboard | Real-Time Status       | Menampilkan status workflow secara realtime | ✅   |
| C-004 | Dashboard | Step Status            | Menampilkan status setiap step              | ✅   |
| C-005 | Dashboard | Run History            | Menampilkan riwayat eksekusi workflow       | ✅   |
| C-006 | Dashboard | Health Dashboard       | Menampilkan statistik workflow              | ✅   |
| C-007 | Dashboard | Average Duration       | Menampilkan rata-rata durasi workflow       | ❌   |
| C-008 | Dashboard | Client Cache           | Cache data pada frontend                    | ❌   |
| C-009 | Dashboard | Optimistic Update      | Update UI sebelum response selesai          | ✅   |

D. Data Layer
| ID    | Modul    | Fitur              | Deskripsi                              | Done  |
| ----- | -------- | ------------------ | -------------------------------------- | ----- | 
| D-001 | Database | Tenant Schema      | Tabel tenant                           | ✅   |
| D-002 | Database | User Schema        | Tabel user dan role                    | ✅   |
| D-003 | Database | Workflow Schema    | Tabel workflow                         | ✅   |
| D-004 | Database | Workflow Version   | Tabel histori versi workflow           | ✅   |
| D-005 | Database | Workflow Run       | Tabel riwayat eksekusi                 | ✅   |
| D-006 | Database | Execution Log      | Penyimpanan log eksekusi               | ✅   |
| D-007 | Database | Query Optimization | Optimasi query dan dokumentasi EXPLAIN | ❌   |
| D-008 | Database | Migration Script   | Contoh migrasi perubahan schema        | ❌   |

E. Infrastructure & Deployment
| ID    | Modul         | Fitur                 | Deskripsi                               | Done  |
| ----- | ------------- | --------------------- | --------------------------------------- | ----- | 
| E-001 | Docker        | Backend Dockerfile    | Dockerfile backend multi-stage          | ❌   |
| E-002 | Docker        | Frontend Dockerfile   | Dockerfile frontend                     | ❌   |
| E-003 | Docker        | Docker Compose        | Menjalankan seluruh service lokal       | ✅   |
| E-004 | CI/CD         | Automated Testing     | Menjalankan lint dan test               | ❌   |
| E-005 | CI/CD         | Build Pipeline        | Build artifact aplikasi                 | ❌   |
| E-006 | Documentation | Infrastructure Design | Diagram dan penjelasan deployment cloud | ❌   |

F. Code Quality & Engineering Practices
| ID    | Modul         | Fitur                | Deskripsi                              | Done  |
| ----- | ------------- | -------------------- | -------------------------------------- | ----- | 
| F-001 | Git           | Clean Commit History | Commit terstruktur dan jelas           | ✅   |
| F-002 | Git           | Feature Branch       | Pengembangan menggunakan branch        | ✅   |
| F-003 | Git           | Pull Request         | Minimal satu pull request              | ❌   |
| F-004 | Testing       | Unit Test            | Test DAG parser dan execution engine   | ❌   |
| F-005 | Testing       | Integration Test     | Test API workflow                      | ❌   |
| F-006 | Testing       | End-to-End Test      | Test workflow dari awal hingga selesai | ❌   |

G. AI-Powered Enhancement (Pilih salah satu)
| ID    | Modul | Fitur                    | Deskripsi                                        | Done  |
| ----- | ----- | ------------------------ | ------------------------------------------------ | ----- |
| G-001 | AI    | Natural Language Builder | Generate workflow dari deskripsi teks            | ❌   |
| G-002 | AI    | Failure Analysis         | Analisis penyebab workflow gagal menggunakan LLM | ❌   |
| G-003 | AI    | Smart Scheduling         | Rekomendasi jadwal berdasarkan histori workflow  | ❌   |
| G-004 | AI    | Prompt Documentation     | Dokumentasi prompt dan validasi output AI        | ❌   |
