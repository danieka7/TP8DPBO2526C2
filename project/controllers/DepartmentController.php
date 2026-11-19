<?php
include_once("config.php");
include_once("models/Department.php");
include_once("views/DepartmentView.php");

class DepartmentController
{
  // Properti kontroller
  private $department;

  // Konstruktor
  function __construct()
  {
    $this->department = new Department(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
  }

  // Mengambil semua data department
  private function getAllData()
  {
    // Menyambungkan/membuka jalur ke database
    $this->department->open();

    // Meneruskan request umum dari view (mengambil data department)
    $this->department->getDepartment();

    // Inisiasi variabel untuk menyimpan data department
    $data = array(
      'department' => array(),
      'edit' => null
    );

    // Push data 1 per 1 ke variabel yang sudah dibuat agar dikemas dalam bentuk array
    while ($row = $this->department->getResult()) {
      array_push($data['department'], $row);
    }

    // Menutup jalur ke database
    $this->department->close();

    return $data;
  }

  // Menerjemahkan input form (view) menjadi data sesuai kolom tabel (model)
  private function mapForm($post)
  {
    return array(
      'code'    => $post['tcode'],
      'name'    => $post['tname'],
      'faculty' => $post['tfaculty']
    );
  }

  // Method yang mengarahkan ke halaman umum controller department
  public function index()
  {
    $data = $this->getAllData();

    // Meneruskannya ke view
    $view = new DepartmentView();
    $view->render($data);
  }

  function add($post)
  {
    $this->department->open();
    $this->department->add($this->mapForm($post));
    $this->department->close();
  }

  // Menampilkan form yang sudah terisi data department yang akan diedit
  function edit($id)
  {
    $data = $this->getAllData();

    $this->department->open();
    $this->department->getDepartmentById($id);
    $data['edit'] = $this->department->getResult();
    $this->department->close();

    $view = new DepartmentView();
    $view->render($data);
  }

  // Menyimpan perubahan dari form edit
  function update($post)
  {
    $this->department->open();
    $this->department->update($post['id'], $this->mapForm($post));
    $this->department->close();
  }

  function delete($id)
  {
    $this->department->open();
    $this->department->delete($id);
    $this->department->close();
  }
}
