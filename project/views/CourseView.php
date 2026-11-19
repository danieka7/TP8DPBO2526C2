<?php

class CourseView
{
  public function render($data)
  {
    $no = 1;
    $dataCourse = null;
    $dataDosen = null;
    $edit = $data['edit'];

    foreach ($data['course'] as $val) {
      $dataCourse .= "<tr class='align-middle'>
                <td class='text-center'>" . $no++ . "</td>
                <td>" . htmlspecialchars($val['code']) . "</td>
                <td>" . htmlspecialchars($val['name']) . "</td>
                <td class='text-center'>" . $val['credits'] . "</td>
                <td class='text-center'>" . $val['semester'] . "</td>
                <td>" . htmlspecialchars($val['lecturer_name']) . "</td>
                <td class='text-center'>
                  <a href='course.php?id_edit=" . $val['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                  <a href='course.php?id_hapus=" . $val['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus mata kuliah ini?')\">Hapus</a>
                </td></tr>";
    }

    // Pilihan dosen; saat edit, dosen pengampu otomatis terpilih
    foreach ($data['lecturer'] as $val) {
      $selected = ($edit && $edit['lecturer_id'] == $val['id']) ? " selected" : "";
      $dataDosen .= "<option value='" . $val['id'] . "'" . $selected . ">" . htmlspecialchars($val['name']) . "</option>";
    }

    $tpl = new Template("templates/course.html");

    $tpl->replace("DATA_JUDUL", "Courses");
    $tpl->replace("DATA_OPTION", $dataDosen);
    $tpl->replace("DATA_TABEL", $dataCourse);

    // Mata kuliah wajib punya dosen pengampu
    if (!$data['lecturer']) {
      $tpl->replace("DATA_ALERT", "<div class='alert alert-warning'>Tambahkan dosen terlebih dahulu sebelum membuat mata kuliah.</div>");
    }

    // Form dipakai untuk tambah dan edit
    if ($edit) {
      $tpl->replace("DATA_FORM_HEADER", "Edit Mata Kuliah");
      $tpl->replace("DATA_ID", $edit['id']);
      $tpl->replace("DATA_CODE", htmlspecialchars($edit['code'], ENT_QUOTES));
      $tpl->replace("DATA_NAME", htmlspecialchars($edit['name'], ENT_QUOTES));
      $tpl->replace("DATA_CREDITS", $edit['credits']);
      $tpl->replace("DATA_SEMESTER", $edit['semester']);
      $tpl->replace("DATA_ACTION", "update");
      $tpl->replace("DATA_BUTTON", "Simpan");
      $tpl->replace("DATA_CANCEL", "<a href='course.php' class='btn btn-secondary mt-3'>Batal</a>");
    } else {
      $tpl->replace("DATA_FORM_HEADER", "Tambah Mata Kuliah");
      $tpl->replace("DATA_CREDITS", 3);
      $tpl->replace("DATA_ACTION", "add");
      $tpl->replace("DATA_BUTTON", "Add");
    }

    $tpl->write();
  }
}
