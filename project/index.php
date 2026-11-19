<?php
include_once("views/Template.php");
include_once("models/DB.php");
include_once("controllers/LecturerController.php");

$lecturer = new LecturerController();

if (isset($_POST['add'])) {
    // Mengambil post data lalu menambahkannya
    $lecturer->add($_POST);

    header("location:index.php");
} else if (isset($_POST['update'])) {
    // Menyimpan perubahan dari form edit
    $lecturer->update($_POST);

    header("location:index.php");
} else if (!empty($_GET['id_hapus'])) {
    // Menghapus data
    $id = $_GET['id_hapus'];
    $lecturer->delete($id);

    header("location:index.php");
} else if (!empty($_GET['id_edit'])) {
    // Menampilkan form edit yang sudah terisi data
    $id = $_GET['id_edit'];
    $lecturer->edit($id);
} else {
    $lecturer->index();
}
