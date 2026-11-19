-- Database untuk TP8 DPBO (MVC)
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
  credits INT NOT NULL DEFAULT 3,
  semester INT NOT NULL,
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
