<?php
include_once("views/Template.php");
include_once("models/DB.php");
include_once("controllers/DepartmentController.php");

$department = new DepartmentController();

if (isset($_POST['add'])) {
    // Menambahkan data
    $department->add($_POST);

    header("location:department.php");
} else if (isset($_POST['update'])) {
    // Menyimpan perubahan dari form edit
    $department->update($_POST);

    header("location:department.php");
} else if (!empty($_GET['id_hapus'])) {
    // Menghapus data
    $id = $_GET['id_hapus'];
    $department->delete($id);

    header("location:department.php");
} else if (!empty($_GET['id_edit'])) {
    // Menampilkan form edit yang sudah terisi data
    $id = $_GET['id_edit'];
    $department->edit($id);
} else {
    $department->index();
}
