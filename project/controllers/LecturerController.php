<?php
include_once("config.php");
include_once("models/Lecturer.php");
include_once("models/Department.php");
include_once("views/LecturerView.php");

class LecturerController
{
  // Properti kontroller
  private $lecturer;
  private $department;

  // Konstruktor
  function __construct()
  {
    $this->lecturer = new Lecturer(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
    $this->department = new Department(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
  }

  // Mengambil semua data lecturer dan department untuk ditampilkan
  private function getAllData()
  {
    // Membuka jalur ke database
    $this->lecturer->open();
    $this->department->open();

    // Meneruskan request dari view
    $this->lecturer->getLecturer();
    $this->department->getDepartment();

    // Inisiasi variabel berbentuk array untuk menyimpan kedua data tabel
    $data = array(
      'lecturer' => array(),
      'department' => array(),
      'edit' => null
    );

    // Push 1 per 1 data dan diteruskan ke variabel yang telah dibuat sebelumnya
    while ($row = $this->lecturer->getResult()) {
      array_push($data['lecturer'], $row);
    }
    while ($row = $this->department->getResult()) {
      array_push($data['department'], $row);
    }

    // Menutup jalur
    $this->lecturer->close();
    $this->department->close();

    return $data;
  }

  // Menerjemahkan input form (view) menjadi data sesuai kolom tabel (model)
  private function mapForm($post)
  {
    return array(
      'name'          => $post['tname'],
      'nidn'          => $post['tnidn'],
      'phone'         => $post['tphone'],
      'email'         => $post['temail'],
      'join_date'     => $post['tjoin'],
      'department_id' => $post['cmbdept']
    );
  }

  // Method umum
  public function index()
  {
    $data = $this->getAllData();

    // Inisiasi variabel untuk memanggil kelas view dan meneruskan datanya
    $view = new LecturerView();
    $view->render($data);
  }

  function add($post)
  {
    $this->lecturer->open();
    $this->lecturer->add($this->mapForm($post));
    $this->lecturer->close();
  }

  // Menampilkan form yang sudah terisi data lecturer yang akan diedit
  function edit($id)
  {
    $data = $this->getAllData();

    $this->lecturer->open();
    $this->lecturer->getLecturerById($id);
    $data['edit'] = $this->lecturer->getResult();
    $this->lecturer->close();

    $view = new LecturerView();
    $view->render($data);
  }

  // Menyimpan perubahan dari form edit
  function update($post)
  {
    $this->lecturer->open();
    $this->lecturer->update($post['id'], $this->mapForm($post));
    $this->lecturer->close();
  }

  function delete($id)
  {
    $this->lecturer->open();
    $this->lecturer->delete($id);
    $this->lecturer->close();
  }
}
