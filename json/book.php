<?php include '../_header.mandatory.php';

  $id = $_GET['id'];
  if (!isset($id)) {
    $id = $_POST['id'];
  }
  if ($id != '') {
    $columns = $database->get("tb_book", "*", array('id' => $id));
  }

  if (is_array($columns)) {
    $fmw->echo_json($columns);
  } else {
    echo "{}";
  }

?>