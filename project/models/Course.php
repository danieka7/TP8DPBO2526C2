<?php

class Course extends DB
{
    // Mata kuliah beserta nama dosen pengampu
    function getCourse()
    {
        $query = "SELECT c.*, l.name AS lecturer_name
                  FROM courses c
                  JOIN lecturers l ON l.id = c.lecturer_id
                  ORDER BY c.id";
        return $this->execute($query);
    }

    function getCourseById($id)
    {
        $id = (int) $id;
        $query = "SELECT * FROM courses WHERE id = $id";
        return $this->execute($query);
    }

    function add($data)
    {
        // Amankan input sebelum dimasukkan ke query
        $code        = $this->quote($data['code']);
        $name        = $this->quote($data['name']);
        $credits     = (int) $data['credits'];
        $semester    = (int) $data['semester'];
        $lecturer_id = (int) $data['lecturer_id'];

        $query = "INSERT INTO courses (code, name, credits, semester, lecturer_id)
                  VALUES ($code, $name, $credits, $semester, $lecturer_id)";
        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($id, $data)
    {
        $id          = (int) $id;
        $code        = $this->quote($data['code']);
        $name        = $this->quote($data['name']);
        $credits     = (int) $data['credits'];
        $semester    = (int) $data['semester'];
        $lecturer_id = (int) $data['lecturer_id'];

        $query = "UPDATE courses
                  SET code = $code, name = $name, credits = $credits,
                      semester = $semester, lecturer_id = $lecturer_id
                  WHERE id = $id";
        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {
        $id = (int) $id;
        $query = "DELETE FROM courses WHERE id = $id";
        // Mengeksekusi query
        return $this->execute($query);
    }
}
