<?php

class Department extends DB
{
    // Prodi beserta jumlah dosen
    function getDepartment()
    {
        $query = "SELECT d.*, COUNT(l.id) AS lecturer_count
                  FROM departments d
                  LEFT JOIN lecturers l ON l.department_id = d.id
                  GROUP BY d.id
                  ORDER BY d.id";
        return $this->execute($query);
    }

    function getDepartmentById($id)
    {
        $id = (int) $id;
        $query = "SELECT * FROM departments WHERE id = $id";
        return $this->execute($query);
    }

    function add($data)
    {
        // Amankan input sebelum dimasukkan ke query
        $code    = $this->quote($data['code']);
        $name    = $this->quote($data['name']);
        $faculty = $this->quote($data['faculty']);

        $query = "INSERT INTO departments (code, name, faculty) VALUES ($code, $name, $faculty)";
        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($id, $data)
    {
        $id      = (int) $id;
        $code    = $this->quote($data['code']);
        $name    = $this->quote($data['name']);
        $faculty = $this->quote($data['faculty']);

        $query = "UPDATE departments SET code = $code, name = $name, faculty = $faculty WHERE id = $id";
        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {
        // department_id dosen di prodi ini menjadi NULL (ON DELETE SET NULL)
        $id = (int) $id;
        $query = "DELETE FROM departments WHERE id = $id";
        // Mengeksekusi query
        return $this->execute($query);
    }
}
