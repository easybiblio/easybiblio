<?php
  include_once '_header.mandatory.php';
  $fmw->checkOperator();
  include '_header.php';

  $lend_id = $_GET['lend_id'];
  $message_alert = '';
  if ($lend_id != '') {
    $lend_columns = $database->get("tb_lend", "*", array("id" => $lend_id));

    // Calculate how many months ago this book was lent
    $query = "select TIMESTAMPDIFF(MONTH, date_lend , DATE_SUB(NOW(), INTERVAL 1 DAY)) from tb_lend where id = " . $database->quote($lend_id);
    $month_ago = $database->query($query)->fetchAll()[0][0];
    
    if ($month_ago > 0) {
      $message_alert = $t->__("bookReturn.message.bookLate", $month_ago);        
    }
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

<h1><?= $t->__('bookReturn.title') ?></h1>


<?php include 'showBook.php' ?>

<?php include 'showPerson.php' ?>



<!-- Loan data -->
<div class="panel panel-success">
   <div class="panel-heading"><?= $t->__('db.lend') ?>:</div>
   <div class="panel-body">
       
    <script>
        $(function() {
            $( "#datepicker" ).datepicker({ dateFormat: "dd/mm/yy" });
        });

        function confirmation() {
            if (confirm("<?= $message_alert . '\n' . $t->__('bookReturn.label.question') ?>")) {
                document.forms["myform"].submit();
            }
        }
    </script>

    <?php if ($message_alert != '') { ?>
    <div class="alert alert-warning" role="alert"><?=$message_alert?></div>
    <?php } ?>

    <form action="bookReturnSave.php" method="post" id="myform">
        <input type="hidden" name="lend_id"   value="<?=$lend_id?>" />

        <table style="border-spacing: 5px; border-collapse: separate;">
          <tr>
            <td width="1%"><?= $t->__('db.lend.date_lend') ?>:</td>
            <td><?=$date_lend?></td>
          </tr>
          <tr>
            <td width="1%"><?= $t->__('db.lend.date_return') ?>:</td>
            <td><input type="text" name="date_return" size="10" value="<?= date('d/m/Y', time()); ?>" id="datepicker"/></td>
          </tr>
          <tr>
            <td width="1%"><?= $t->__('db.lend.notes') ?>:</td>
            <td>
                <textarea rows="6" cols="50" name="notes" autofocus><?= $fmw->escapeHtml($notes) ?></textarea>
            </td>
          </tr>
          <tr>
              <td></td>
              <td>
                <input type="button" class="btn btn-default" name="Submit" value="<?= $t->__('bookReturn.button.confirmReturn') ?>" onclick="confirmation()" />
                <input type="button" class="btn btn-default" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='bookSearch.php'" />
              </td>
          </tr>
        </table>

    </form>
       
   </div>
</div>



<?php include '_footer.php' ?>
