<?php
include_once("views/Template.php");
include_once("models/DB.php");
include_once("controllers/CourseController.php");

$course = new CourseController();

if (isset($_POST['add'])) {
    // Menambahkan data
    $course->add($_POST);

    header("location:course.php");
} else if (isset($_POST['update'])) {
    // Menyimpan perubahan dari form edit
    $course->update($_POST);

    header("location:course.php");
} else if (!empty($_GET['id_hapus'])) {
    // Menghapus data
    $id = $_GET['id_hapus'];
    $course->delete($id);

    header("location:course.php");
} else if (!empty($_GET['id_edit'])) {
    // Menampilkan form edit yang sudah terisi data
    $id = $_GET['id_edit'];
    $course->edit($id);
} else {
    $course->index();
}
