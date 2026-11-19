<?php

class Lecturer extends DB
{
    // Dosen beserta nama prodi dan jumlah mata kuliah yang diampu
    function getLecturer()
    {
        $query = "SELECT l.*, d.name AS department_name, COUNT(c.id) AS course_count
                  FROM lecturers l
                  LEFT JOIN departments d ON d.id = l.department_id
                  LEFT JOIN courses c ON c.lecturer_id = l.id
                  GROUP BY l.id
                  ORDER BY l.id";
        return $this->execute($query);
    }

    function getLecturerById($id)
    {
        $id = (int) $id;
        $query = "SELECT * FROM lecturers WHERE id = $id";
        return $this->execute($query);
    }

    function add($data)
    {
        // Amankan input sebelum dimasukkan ke query
        $name          = $this->quote($data['name']);
        $nidn          = $this->quote($data['nidn']);
        $phone         = $this->quote($data['phone']);
        $email         = $this->quote($data['email']);
        $join_date     = $this->quote($data['join_date']);
        $department_id = $data['department_id'] === "" ? "NULL" : (int) $data['department_id'];

        $query = "INSERT INTO lecturers (name, nidn, phone, email, join_date, department_id)
                  VALUES ($name, $nidn, $phone, $email, $join_date, $department_id)";
        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($id, $data)
    {
        $id            = (int) $id;
        $name          = $this->quote($data['name']);
        $nidn          = $this->quote($data['nidn']);
        $phone         = $this->quote($data['phone']);
        $email         = $this->quote($data['email']);
        $join_date     = $this->quote($data['join_date']);
        $department_id = $data['department_id'] === "" ? "NULL" : (int) $data['department_id'];

        $query = "UPDATE lecturers
                  SET name = $name, nidn = $nidn, phone = $phone, email = $email,
                      join_date = $join_date, department_id = $department_id
                  WHERE id = $id";
        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {
        // Mata kuliah yang diampu dosen ini ikut terhapus (ON DELETE CASCADE)
        $id = (int) $id;
        $query = "DELETE FROM lecturers WHERE id = $id";
        // Mengeksekusi query
        return $this->execute($query);
    }
}
