# File Renaming Strategy - Copyright Avoidance

## Overview
This document outlines the systematic renaming strategy to transform all file names and components to avoid copyright issues while maintaining functionality.

## Core Concept Mapping

### Models (app/Models/)
| Original | New Name | Reasoning |
|----------|----------|-----------|
| Ujian | Tes | Exam → Test |
| Soal | Pertanyaan | Question → Question (different term) |
| Jawaban | Pilihan | Answer → Choice |
| PaketUjian | BundleTes | Exam Package → Test Bundle |
| Pembelian | Transaksi | Purchase → Transaction |
| UjianUser | PesertaTes | ExamUser → Test Participant |
| JawabanPeserta | ResponPeserta | Participant Answer → Participant Response |
| BankSoal | KoleksiPertanyaan | Question Bank → Question Collection |
| Pengumuman | InfoPenting | Announcement → Important Info |
| Faq | DuniaHelp | FAQ → Help World |
| Voucher | KuponDiskon | Voucher → Discount Coupon |
| Formasi | Jabatan | Formation → Position |
| Prodi | ProgramStudi | Prodi → Study Program |
| Wilayah | Lokasi | Region → Location |
| LiveClass | KelasLangsung | Live Class → Direct Class |
| Material | MateriPembelajaran | Material → Learning Material |

### Controllers (app/Http/Controllers/)
| Original | New Name |
|----------|----------|
| UjianController | TesController |
| SoalController | PertanyaanController |
| PembelianController | TransaksiController |
| PaketUjianController | BundleTesController |
| PesertaUjianController | PesertaTesController |
| PengumumanController | InfoPentingController |
| FaqController | DuniaHelpController |
| VoucherController | KuponDiskonController |
| BankSoalController | KoleksiPertanyaanController |
| FormasiController | JabatanController |
| WilayahController | LokasiController |
| LiveClassController | KelasLangsungController |
| MaterialController | MateriPembelajaranController |
| UserMaterialController | UserMateriController |

### Views (resources/views/)
| Original Directory | New Directory |
|-------------------|---------------|
| views_user/ujian/ | views_user/tes/ |
| views_user/pembelian/ | views_user/transaksi/ |
| views_user/pengumuman/ | views_user/info/ |
| views_user/faq/ | views_user/bantuan/ |
| views_user/materials/ | views_user/materi/ |
| admin/ujian/ | admin/tes/ |
| admin/soal/ | admin/pertanyaan/ |
| admin/paket_ujian/ | admin/bundle_tes/ |
| admin/pembelian/ | admin/transaksi/ |
| admin/peserta_ujian/ | admin/peserta_tes/ |
| admin/pengumuman/ | admin/info/ |
| admin/faq/ | admin/bantuan/ |
| admin/voucher/ | admin/kupon/ |
| admin/bank_soal/ | admin/koleksi_pertanyaan/ |
| tutor/live-classes/ | tutor/kelas-langsung/ |
| tutor/materials/ | tutor/materi/ |

### Database Tables (migrations)
| Original | New Name |
|----------|----------|
| ujian | tes |
| soal | pertanyaan |
| jawaban | pilihan |
| paket_ujian | bundle_tes |
| pembelian | transaksi |
| ujian_user | peserta_tes |
| jawaban_peserta | respon_peserta |
| bank_soal | koleksi_pertanyaan |
| pengumuman | info_penting |
| faq | dunia_help |
| voucher | kupon_diskon |
| formasi | jabatan |
| prodi | program_studi |
| wilayah | lokasi |
| live_classes | kelas_langsung |
| materials | materi_pembelajaran |

### Route Names
| Original Pattern | New Pattern |
|-----------------|-------------|
| tryout.* | tes.* |
| ujian.* | testing.* |
| admin.ujian.* | admin.tes.* |
| admin.soal.* | admin.pertanyaan.* |
| admin.paket.* | admin.bundle.* |
| pembelian.* | transaksi.* |
| pengumuman.* | info.* |
| faq.* | bantuan.* |
| materials.* | materi.* |
| live-classes.* | kelas-langsung.* |

## Implementation Order

### Phase 1: Create New Model Files
1. Create new model files with new names
2. Maintain same relationships and methods
3. Keep both old and new temporarily

### Phase 2: Create New Controllers
1. Create new controllers with updated model references
2. Update all method logic to use new models
3. Keep routes pointing to old controllers initially

### Phase 3: Update Routes
1. Update web.php to use new controllers
2. Update route names to new convention
3. Test each route group after update

### Phase 4: Create New Views
1. Copy view directories to new names
2. Update all model references in views
3. Update all route references in views

### Phase 5: Update Database References
1. Create new migrations for table renames
2. Update seeders to use new table names
3. Run migrations to rename tables

### Phase 6: Cleanup
1. Remove old model files
2. Remove old controller files
3. Remove old view files
4. Update all documentation

## Critical Update Points

### Files requiring namespace updates:
- All Controllers
- All Models
- All Seeders
- All Factories
- All Policies
- Route files
- Config files

### Files requiring class name updates:
- All blade views using @model directives
- All JavaScript files with model references
- All configuration arrays

### Files requiring route name updates:
- All blade views with route() helpers
- All controllers with redirect() calls
- All middleware configurations

## Testing Checklist
- [ ] Login functionality
- [ ] Registration
- [ ] Dashboard access
- [ ] Test creation (admin)
- [ ] Question management
- [ ] Purchase/Transaction flow
- [ ] Test taking
- [ ] Results viewing
- [ ] Materials access
- [ ] Live class functionality
- [ ] All API endpoints