<?php
include_once("config.php");
include_once("models/Course.php");
include_once("models/Lecturer.php");
include_once("views/CourseView.php");

class CourseController
{
  // Properti kontroller
  private $course;
  private $lecturer;

  // Konstruktor
  function __construct()
  {
    $this->course = new Course(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
    $this->lecturer = new Lecturer(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
  }

  // Mengambil semua data course dan lecturer untuk ditampilkan
  private function getAllData()
  {
    // Membuka jalur ke database
    $this->course->open();
    $this->lecturer->open();

    // Meneruskan request dari view
    $this->course->getCourse();
    $this->lecturer->getLecturer();

    // Inisiasi variabel berbentuk array untuk menyimpan kedua data tabel
    $data = array(
      'course' => array(),
      'lecturer' => array(),
      'edit' => null
    );

    // Push 1 per 1 data dan diteruskan ke variabel yang telah dibuat sebelumnya
    while ($row = $this->course->getResult()) {
      array_push($data['course'], $row);
    }
    while ($row = $this->lecturer->getResult()) {
      array_push($data['lecturer'], $row);
    }

    // Menutup jalur
    $this->course->close();
    $this->lecturer->close();

    return $data;
  }

  // Menerjemahkan input form (view) menjadi data sesuai kolom tabel (model)
  private function mapForm($post)
  {
    return array(
      'code'        => $post['tcode'],
      'name'        => $post['tname'],
      'credits'     => $post['tcredits'],
      'semester'    => $post['tsemester'],
      'lecturer_id' => $post['cmbdosen']
    );
  }

  // Method umum
  public function index()
  {
    $data = $this->getAllData();

    // Inisiasi variabel untuk memanggil kelas view dan meneruskan datanya
    $view = new CourseView();
    $view->render($data);
  }

  function add($post)
  {
    $this->course->open();
    $this->course->add($this->mapForm($post));
    $this->course->close();
  }

  // Menampilkan form yang sudah terisi data course yang akan diedit
  function edit($id)
  {
    $data = $this->getAllData();

    $this->course->open();
    $this->course->getCourseById($id);
    $data['edit'] = $this->course->getResult();
    $this->course->close();

    $view = new CourseView();
    $view->render($data);
  }

  // Menyimpan perubahan dari form edit
  function update($post)
  {
    $this->course->open();
    $this->course->update($post['id'], $this->mapForm($post));
    $this->course->close();
  }

  function delete($id)
  {
    $this->course->open();
    $this->course->delete($id);
    $this->course->close();
  }
}
