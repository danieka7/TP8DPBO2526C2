# Tugas Praktikum 8 - Desain Pemrograman Berorientasi Objek

## Janji
Saya **Dani Eka Saputra** dengan NIM **2501158** mengerjakan Tugas Praktikum 8 pada Mata Kuliah Desain Pemrograman Berorientasi Objek untuk keberkahan-Nya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin


## Penjelasan Tema
Program ini bertema sistem manajemen data dosen di lingkungan kampus. Program mencatat data dosen (*lecturers*), program studi tempat dosen bernaung (*departments*), serta mata kuliah yang diampu oleh setiap dosen (*courses*). Project dibangun menggunakan arsitektur **MVC (Model - View - Controller)**: Model mengurus query ke database, View menyusun tampilan dari template HTML, dan Controller menjadi penghubung antara keduanya.


## Fitur Utama

1. **Manajemen Dosen (Lecturer - CRUD)** *(tabel lama, ditambah atribut `email` dan `department_id`)*
   - **Create**: Menambahkan dosen baru beserta nama, NIDN unik, nomor HP, email (opsional), tanggal bergabung, dan prodi (opsional).
   - **Read**: Menampilkan daftar dosen lengkap dengan nama prodi dan jumlah mata kuliah yang diampu menggunakan `LEFT JOIN` + `COUNT`.
   - **Update**: Mengubah data dosen melalui form yang otomatis terisi data lama; prodi dosen otomatis terpilih pada *dropdown*.
   - **Delete**: Menghapus dosen; mata kuliah yang diampunya ikut terhapus (`ON DELETE CASCADE`).

2. **Manajemen Program Studi (Department - CRUD)** *(tabel baru 1)*
   - **Create**: Menambahkan prodi baru (kode unik, nama prodi, fakultas).
   - **Read**: Menampilkan daftar prodi beserta jumlah dosen di setiap prodi.
   - **Update**: Mengubah data prodi.
   - **Delete**: Menghapus prodi; dosen di prodi tersebut tidak ikut terhapus, melainkan `department_id`-nya menjadi `NULL` (`ON DELETE SET NULL`).

3. **Manajemen Mata Kuliah (Course - CRUD)** *(tabel baru 2)*
   - **Create**: Menambahkan mata kuliah (kode unik, nama, SKS, semester, dosen pengampu). Muncul peringatan bila belum ada dosen.
   - **Read**: Menampilkan daftar mata kuliah beserta nama dosen pengampu menggunakan `JOIN`.
   - **Update**: Mengubah data mata kuliah; dosen pengampu otomatis terpilih pada *dropdown*.
   - **Delete**: Menghapus mata kuliah.

## Arsitektur MVC

| Lapisan        | Lokasi                      | Tugas                                                                                                             |
| -------------- | --------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| **Model**      | `project/models/`           | `DB.php` sebagai kelas induk koneksi (`open`, `execute`, `getResult`, `close`); `Lecturer`, `Department`, `Course` mewarisi `DB` dan berisi query CRUD. |
| **View**       | `project/views/`            | `LecturerView`, `DepartmentView`, `CourseView` menyusun baris tabel & form, lalu mengisi template lewat `Template.php`. |
| **Template**   | `project/templates/`        | File HTML berisi placeholder (`DATA_TABEL`, `DATA_FORM_HEADER`, dll.) yang diganti oleh View.                    |
| **Controller** | `project/controllers/`      | Mengambil data dari Model, menerjemahkan input form (`mapForm`), lalu meneruskan data ke View.                    |
| **Entry point**| `index.php`, `department.php`, `course.php` | Membaca request (`$_POST['add']`, `$_POST['update']`, `?id_edit=`, `?id_hapus=`) dan memanggil method Controller. |

**Alur request:**
```
Browser → index.php / department.php / course.php
        → Controller (add / edit / update / delete / index)
        → Model (query ke database tp_mvc25)
        → Controller → View → Template (HTML) → Browser
```


## Struktur Projek

```
TP8DPBO2526C2
├── database
│   └── tp_mvc25.sql
├── dokumentasi
├── project
│   ├── assets
│   │   ├── bootstrap.bundle.min.js
│   │   ├── bootstrap.min.css
│   │   ├── bootstrap.min.js
│   │   ├── jquery.min.js
│   │   └── popper.min.js
│   ├── controllers
│   │   ├── CourseController.php
│   │   ├── DepartmentController.php
│   │   └── LecturerController.php
│   ├── models
│   │   ├── Course.php
│   │   ├── DB.php
│   │   ├── Department.php
│   │   └── Lecturer.php
│   ├── templates
│   │   ├── course.html
│   │   ├── department.html
│   │   └── lecturer.html
│   ├── views
│   │   ├── CourseView.php
│   │   ├── DepartmentView.php
│   │   ├── LecturerView.php
│   │   └── Template.php
│   ├── config.php
│   ├── course.php
│   ├── department.php
│   └── index.php
└── README.md
```

## Skema Tabel & Relasi

#### 1. Tabel `departments` *(tabel baru)*
Menyimpan data program studi.
| Kolom     | Tipe Data                     | Keterangan               |
| --------- | ----------------------------- | ------------------------ |
| `id`      | `INT AUTO_INCREMENT`          | **Primary Key**          |
| `code`    | `VARCHAR(10) NOT NULL UNIQUE` | Kode prodi unik          |
| `name`    | `VARCHAR(100) NOT NULL`       | Nama program studi       |
| `faculty` | `VARCHAR(100) NOT NULL`       | Nama fakultas            |

#### 2. Tabel `lecturers` *(tabel lama, ditambah `email` dan `department_id`)*
Menyimpan data dosen dan memiliki relasi *Many-to-One* ke tabel `departments`.
| Kolom           | Tipe Data                     | Keterangan                                                                 |
| --------------- | ----------------------------- | -------------------------------------------------------------------------- |
| `id`            | `INT AUTO_INCREMENT`          | **Primary Key**                                                            |
| `name`          | `VARCHAR(100) NOT NULL`       | Nama dosen                                                                 |
| `nidn`          | `VARCHAR(20) NOT NULL UNIQUE` | Nomor Induk Dosen Nasional                                                 |
| `phone`         | `VARCHAR(20) NOT NULL`        | Nomor HP                                                                   |
| `email`         | `VARCHAR(100) NULL`           | Email dosen (opsional) — **atribut baru**                                  |
| `join_date`     | `DATE NOT NULL`               | Tanggal bergabung                                                          |
| `department_id` | `INT NULL`                    | **Foreign Key** mengacu ke `departments(id)`, `ON DELETE SET NULL` — **atribut baru** |

#### 3. Tabel `courses` *(tabel baru)*
Menyimpan data mata kuliah dan memiliki relasi *Many-to-One* ke tabel `lecturers`.
| Kolom         | Tipe Data                     | Keterangan                                                        |
| ------------- | ----------------------------- | ----------------------------------------------------------------- |
| `id`          | `INT AUTO_INCREMENT`          | **Primary Key**                                                   |
| `code`        | `VARCHAR(10) NOT NULL UNIQUE` | Kode mata kuliah unik                                             |
| `name`        | `VARCHAR(100) NOT NULL`       | Nama mata kuliah                                                  |
| `credits`     | `TINYINT NOT NULL DEFAULT 3`  | Jumlah SKS                                                        |
| `semester`    | `TINYINT NOT NULL`            | Semester                                                          |
| `lecturer_id` | `INT NOT NULL`                | **Foreign Key** mengacu ke `lecturers(id)`, `ON DELETE CASCADE`   |

**Relasi:**
```
departments (1) ──< (N) lecturers (1) ──< (N) courses
```

## Database

```
DROP DATABASE IF EXISTS tp_mvc25;
CREATE DATABASE tp_mvc25;
USE tp_mvc25;

-- Tabel baru 1: program studi
CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(10) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  faculty VARCHAR(100) NOT NULL
);

-- Tabel lama (ditambah atribut email dan department_id)
CREATE TABLE lecturers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  nidn VARCHAR(20) NOT NULL UNIQUE,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(100) NULL,
  join_date DATE NOT NULL,
  department_id INT NULL,
  CONSTRAINT fk_lecturer_department FOREIGN KEY (department_id)
    REFERENCES departments(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- Tabel baru 2: mata kuliah yang diampu dosen
CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(10) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  credits TINYINT NOT NULL DEFAULT 3,
  semester TINYINT NOT NULL,
  lecturer_id INT NOT NULL,
  CONSTRAINT fk_course_lecturer FOREIGN KEY (lecturer_id)
    REFERENCES lecturers(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO departments (code, name, faculty) VALUES
('IK', 'Ilmu Komputer', 'FPMIPA'),
('PIK', 'Pendidikan Ilmu Komputer', 'FPMIPA'),
('MAT', 'Matematika', 'FPMIPA');

INSERT INTO lecturers (name, nidn, phone, email, join_date, department_id) VALUES
('Budi Santoso', '0012345601', '081234567801', 'budi@kampus.ac.id', '2015-08-01', 1),
('Siti Rahmawati', '0012345602', '081234567802', 'siti@kampus.ac.id', '2018-02-15', 2),
('Andi Pratama', '0012345603', '081234567803', 'andi@kampus.ac.id', '2020-09-10', 1);

INSERT INTO courses (code, name, credits, semester, lecturer_id) VALUES
('IK201', 'Desain dan Pemrograman Berorientasi Objek', 3, 3, 1),
('IK202', 'Basis Data', 3, 3, 3),
('PIK101', 'Algoritma dan Pemrograman', 4, 1, 2);
```

## Dokumentasi