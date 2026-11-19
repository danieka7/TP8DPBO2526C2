<?php

class DepartmentView
{
  public function render($data)
  {
    $no = 1;
    $dataDept = null;
    $edit = $data['edit'];

    foreach ($data['department'] as $val) {
      $dataDept .= "<tr class='align-middle'>
                <td class='text-center'>" . $no++ . "</td>
                <td>" . htmlspecialchars($val['code']) . "</td>
                <td>" . htmlspecialchars($val['name']) . "</td>
                <td>" . htmlspecialchars($val['faculty']) . "</td>
                <td class='text-center'>" . $val['lecturer_count'] . "</td>
                <td class='text-center'>
                  <a href='department.php?id_edit=" . $val['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                  <a href='department.php?id_hapus=" . $val['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus prodi ini? Dosen di prodi ini tidak lagi memiliki prodi.')\">Hapus</a>
                </td></tr>";
    }

    $tpl = new Template("templates/department.html");
    $tpl->replace("DATA_JUDUL", "Departments");
    $tpl->replace("DATA_TABEL", $dataDept);

    // Form dipakai untuk tambah dan edit
    if ($edit) {
      $tpl->replace("DATA_FORM_HEADER", "Edit Prodi");
      $tpl->replace("DATA_ID", $edit['id']);
      $tpl->replace("DATA_CODE", htmlspecialchars($edit['code'], ENT_QUOTES));
      $tpl->replace("DATA_NAME", htmlspecialchars($edit['name'], ENT_QUOTES));
      $tpl->replace("DATA_FACULTY", htmlspecialchars($edit['faculty'], ENT_QUOTES));
      $tpl->replace("DATA_ACTION", "update");
      $tpl->replace("DATA_BUTTON", "Simpan");
      $tpl->replace("DATA_CANCEL", "<a href='department.php' class='btn btn-secondary mt-3'>Batal</a>");
    } else {
      $tpl->replace("DATA_FORM_HEADER", "Tambah Prodi");
      $tpl->replace("DATA_ACTION", "add");
      $tpl->replace("DATA_BUTTON", "Add");
    }

    $tpl->write();
  }
}
