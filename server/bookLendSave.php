<?php 
  include_once '_header.mandatory.php';

  use Medoo\Medoo;

  $fmw->checkOperator();

  $book_id = $_POST['book_id'];
  if ($book_id != '') {
    $book_columns = $database->get("tb_book", "*", array("id" => $book_id));
  }

  $person_id = $_POST['person_id'];
  if ($person_id != '') {
    $person_columns = $database->get("tb_person", "*", array("id" => $person_id));
  }

  $date_lend = $_POST['date_lend'];
  $notes = $_POST['notes'];

  if (!isset($book_columns['id'])) {
      $fmw->error('bookLendSave.message.bookNotFound');
  } else if (!isset($person_columns['id'])) {
      $fmw->error('bookLendSave.message.personNotFound');
  } else if (!$fmw->verifyDate($date_lend)) {
      $fmw->error('bookLendSave.message.dateNotValid');
  } else {
    // Check if book is already lended
      $query = "select * from tb_lend where book_id = " . $book_id . " and date_return is null";
      $book_already_lended = $database->query($query)->fetchAll();
      if (count($book_already_lended) > 0) {
          error('bookLendSave.message.bookAlreadyLent');
      }
  }

  if (!$fmw->hasError()) {
      // Validation is OK, let's save.
      
    $columns = array(
        "book_id" => $book_id,
        "person_id" => $person_id,
        "date_lend" => Medoo::raw("STR_TO_DATE('" . $date_lend . "','%d/%m/%Y')"),
        "notes" => $notes,
        'date_creation' => Medoo::raw("STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')")
    );

    $database->insert("tb_lend", $columns);
    $last_book_lend_id = $database->id();
	$fmw->info('bookLendSave.message.success', $book_columns['title'], $last_book_lend_id);
    $fmw->checkDatabaseError();

    // Audit
    $toAudit = 'bookCode: '   . $book_columns['code']  . ', ';
    $toAudit .= 'bookTitle: ' . $book_columns['title'] . ', ';
    $toAudit .= 'personName: ' . $person_columns['name'];
    $audit->bookLent($toAudit);
      
    $fmw->checkDatabaseError();
  }

  header("Location: bookSearch.php");
?>