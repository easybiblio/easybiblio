<?php
  include '_header.php';

  $book_id = $_POST['book_id'];
  if ($book_id != '') {
    $book_columns = $database->get("tb_book", "*", array("id" => $book_id));
    $fmw->escapeHtmlArray($book_columns);
  }

  $person_id = $_POST['person_id'];
  if ($person_id != '') {
    $person_columns = $database->get("tb_person", "*", array("id" => $person_id));
    $fmw->escapeHtmlArray($person_columns);
  }

  $date_lend = $_POST['date_lend'];
  $notes = $_POST['notes'];
?>

<h1><?= $t->__('bookLendConfirmation.title') ?></h1>


<!-- Book -->
<div class="panel panel-success">
   <div class="panel-heading"><?= $t->__('db.book') ?>:</div>
   <div class="panel-body">


    <table>
      <tr>
            <?php
                if ($book_columns['cover_url'] != '') {
                    $img_src_nocache = $fmw->escapeHtml($book_columns['cover_url']) . '?' . time();
                    echo "<td rowspan='3' width='150px'>";
                    echo "<img src='".$img_src_nocache."' width='130'/>";
                    echo "</td>";
                }
            ?>
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
       
       
   </div>
</div>





<!-- Person -->
<br/>
<div class="panel panel-success">
   <div class="panel-heading"><?= $t->__('db.person') ?>:</div>
   <div class="panel-body">
       
       
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
       
       
   </div>
</div>

<h3></h3>



<!-- Loan Data -->
<br/>
<div class="panel panel-success">
   <div class="panel-heading"><?= $t->__('db.lend') ?>:</div>
   <div class="panel-body">
       
    <table style="border-spacing: 5px; border-collapse: separate;">
      <tr>
        <td width="1%"><?= $t->__('db.lend.date_lend') ?>:</td>
        <td><?=$date_lend?></td>
      </tr>
      <tr>
        <td width="1%"><?= $t->__('db.lend.notes') ?>:</td>
        <td><?=$fmw->escapeHtml($notes)?></td>
      </tr>
    </table>
       
   </div>
</div>


<br/>

<form action="bookLendConfirmationSave.php" method="post">
    <input type="hidden" name="book_id"   value="<?=$book_id?>" />
    <input type="hidden" name="person_id" value="<?=$person_id?>" />
    <input type="hidden" name="date_lend" value="<?=$date_lend?>" />
    <input type="hidden" name="notes"     value="<?=$fmw->escapeHtml($notes)?>" />
    <input type="submit" class="btn btn-default"
 name="Submit" value="<?= $t->__('button.confirmLend') ?>">
    <input type="button" class="btn btn-default"
 value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='bookSearch.php'">
</form>

<?php include '_footer.php' ?>
