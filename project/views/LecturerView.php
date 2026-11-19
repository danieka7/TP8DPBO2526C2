<?php

class LecturerView
{
  public function render($data)
  {
    $no = 1;
    $dataLecturer = null;
    $dataDept = null;
    $edit = $data['edit'];

    foreach ($data['lecturer'] as $val) {
      $dataLecturer .= "<tr class='align-middle'>
                <td class='text-center'>" . $no++ . "</td>
                <td>" . htmlspecialchars($val['name']) . "</td>
                <td>" . htmlspecialchars($val['nidn']) . "</td>
                <td>" . htmlspecialchars($val['phone']) . "</td>
                <td>" . htmlspecialchars($val['email'] ?? '-') . "</td>
                <td>" . htmlspecialchars($val['join_date']) . "</td>
                <td>" . htmlspecialchars($val['department_name'] ?? '-') . "</td>
                <td class='text-center'>" . $val['course_count'] . "</td>
                <td class='text-center'>
                  <a href='index.php?id_edit=" . $val['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                  <a href='index.php?id_hapus=" . $val['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus dosen ini? Mata kuliah yang diampunya juga akan terhapus.')\">Hapus</a>
                </td></tr>";
    }

    // Pilihan department; saat edit, department milik dosen otomatis terpilih
    foreach ($data['department'] as $val) {
      $selected = ($edit && $edit['department_id'] == $val['id']) ? " selected" : "";
      $dataDept .= "<option value='" . $val['id'] . "'" . $selected . ">" . htmlspecialchars($val['code'] . " - " . $val['name']) . "</option>";
    }

    $tpl = new Template("templates/lecturer.html");

    $tpl->replace("DATA_JUDUL", "Lecturers");
    $tpl->replace("DATA_OPTION", $dataDept);
    $tpl->replace("DATA_TABEL", $dataLecturer);

    // Form dipakai untuk tambah dan edit
    if ($edit) {
      $tpl->replace("DATA_FORM_HEADER", "Edit Dosen");
      $tpl->replace("DATA_ID", $edit['id']);
      $tpl->replace("DATA_NAME", htmlspecialchars($edit['name'], ENT_QUOTES));
      $tpl->replace("DATA_NIDN", htmlspecialchars($edit['nidn'], ENT_QUOTES));
      $tpl->replace("DATA_PHONE", htmlspecialchars($edit['phone'], ENT_QUOTES));
      $tpl->replace("DATA_EMAIL", htmlspecialchars((string) $edit['email'], ENT_QUOTES));
      $tpl->replace("DATA_JOIN", $edit['join_date']);
      $tpl->replace("DATA_ACTION", "update");
      $tpl->replace("DATA_BUTTON", "Simpan");
      $tpl->replace("DATA_CANCEL", "<a href='index.php' class='btn btn-secondary mt-3'>Batal</a>");
    } else {
      $tpl->replace("DATA_FORM_HEADER", "Tambah Dosen");
      $tpl->replace("DATA_ACTION", "add");
      $tpl->replace("DATA_BUTTON", "Add");
    }

    $tpl->write();
  }
}
