<?php include '../_header.mandatory.php';

  $columns = $database->select("tb_about", "*");

  if (is_array($columns)) {
      if (is_array($columns[0])) {
        $fmw->echo_json($columns[0]);
      } else {
        echo "{}";
      }
  } else {
    echo "{}";
  }

?>