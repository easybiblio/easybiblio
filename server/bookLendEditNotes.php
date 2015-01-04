<?php
  include '_header.php';

  $lend_id = $_GET['lend_id'];
  if ($lend_id != '') {
    $lend_columns = $database->get("tb_lend", "*", array("id" => $lend_id));
  }

  $book_id = $lend_columns['book_id'];
  if ($book_id != '') {
    $book_columns = $database->get("tb_book", "*", array("id" => $book_id));
    $fmw->escapeHtmlArray($book_columns);
  }

  $person_id = $lend_columns['person_id'];
  if ($person_id != '') {
    $person_columns = $database->get("tb_person", "*", array("id" => $person_id));
    $fmw->escapeHtmlArray($person_columns);
  }

  $date_lend = $lend_columns['date_lend'];
  $notes = $lend_columns['notes'];
?>

<h1><?= $t->__('bookLendEditNotes.title') ?></h1>

<h3><?= $t->__('db.book') ?>:</h3>
<table style="border-spacing: 5px; border-collapse: separate;">
  <tr>
    <td width="1%"><?= $t->__('db.book.title') ?>:</td>
    <td>(<?=$book_columns['code'] ?>) <?=$book_columns['title'] ?></td>
  </tr>
    
  <tr>
    <td><?= $t->__('db.book.author') ?>:</td>
    <td><?=$book_columns['author'] ?></td>
  </tr>
   
  <tr>
    <td><?= $t->__('db.book.coauthor') ?>:</td>
    <td><?=$book_columns['coauthor'] ?></td>
  </tr>
</table>

<h3><?= $t->__('db.person') ?>:</h3>
<table style="border-spacing: 5px; border-collapse: separate;">
  <tr>
    <td width="1%"><?= $t->__('db.person.name') ?>:</td>
    <td><?=$person_columns['name'] ?></td>
  </tr>
  <tr>
    <td><?= $t->__('db.person.city') ?>:</td>
    <td><?=$person_columns['city'] ?></td>
  </tr>
  <tr>
    <td><?= $t->__('db.person.phone1') ?>:</td>
    <td><?=$person_columns['phone1'] ?></td>
  </tr>
  <tr>
    <td><?= $t->__('db.person.phone2') ?>:</td>
    <td><?=$person_columns['phone2'] ?></td>
  </tr>
  <tr>
    <td><?= $t->__('db.person.email') ?>:</td>
    <td><?=$person_columns['email'] ?></td>
  </tr>
</table>



<h3><?= $t->__('db.lend') ?>:</h3>

<form action="bookLendEditNotesSave.php" method="post" id="myform">
    <input type="hidden" name="lend_id"   value="<?=$lend_id?>" />

<table style="border-spacing: 5px; border-collapse: separate;">
  <tr>
    <td width="1%"><?= $t->__('db.lend.date_lend') ?>:</td>
    <td><?=$date_lend?></td>
  </tr>
  <tr>
    <td width="1%"><?= $t->__('db.lend.notes') ?>:</td>
    <td>
        <textarea rows="6" cols="50" name="notes" autofocus><?= $fmw->escapeHtml($notes) ?></textarea>
    </td>
    
  </tr>
</table>

<br/>

    <input type="submit" name="Submit" value="<?= $t->__('button.save') ?>" />
    <input type="button" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='reportBookLended.php'" />
</form>

<?php include '_footer.php' ?>
