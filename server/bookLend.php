<?php
  include '_header.php';

  $book_id = $_GET['book_id'];
  if ($book_id != '') {
    $book_columns = $database->get("tb_book", "*", array("id" => $book_id));
    $fmw->escapeHtmlArray($book_columns);
  }
?>

<h1><?= $t->__('bookLend.title') ?></h1>


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
            <td width="1px"><?= $t->__('db.book.title') ?>:</td>
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
<div class="panel panel-success">
<div class="panel-heading"><?= $t->__('db.person') ?>:</div>
    
<div class="panel-body">

<script>
    function _personSelected(personId) {
        $('#person_id_for_loan').val(personId);
        $('#loan_data_submit_button').prop("disabled",false);
    }
</script>

<?php
    $search_string = $_POST['search_person'];
    if (!isset($search_string)) {
        $search_string = $_SESSION['search_person'];
    } else {
        $_SESSION['search_person'] = $search_string;
    }
    $search_string = trim($search_string);
?>
<form class="navbar-form navbar-left" role="search" method="post">
    <div class="form-group">
      <input type="search" class="form-control" name="search_person" value="<?= $fmw->escapeHtml($search_string) ?>" autofocus/>
    </div>
    <input type="submit" class="btn btn-default" value="<?= $t->__('button.search') ?>"/>
    <input type="button" class="btn btn-default" value="<?= $t->__('button.newPerson') ?>" onclick="window.location.href='person.php'" />
</form>

<table class="table table-hover">
    <tr>
        <th width="1%"></th>
        <th><?= $t->__('db.person.name') ?></th>
        <th><?= $t->__('db.person.city') ?></th>
        <th><?= $t->__('db.person.phone1') ?></th>
        <th><?= $t->__('db.person.phone2') ?></th>
        <th><?= $t->__('db.person.email') ?></th>
    </tr>
<?php

$datas = $database->select("tb_person", "*",  array(
                    'LIKE' => array(
                        'OR' => array( 'name' => $search_string,
                                  'email' => $search_string )
                                )
                    ));

foreach($datas as $row) {
    $fmw->escapeHtmlArray($row);
    echo "<tr>";
    echo "<td>";
    echo "<input type='radio' name='person_id' onchange='javascript:_personSelected(\"". $row['id'] . "\")'/>";
    echo "</td>";
    echo "<td>";
    echo "<a href='person.php?id=" . $row['id'] . "'>" . $row['name'] . '</a>';
    echo "</td>";
    echo "<td>";
    echo $row['zipcode'].' '.$row['city'];
    echo "</td>";
    echo "<td>";
    echo $row['phone1'];
    echo "</td>";
    echo "<td>";
    echo $row['phone2'];
    echo "</td>";
    echo "<td>";
    echo $row['email'];
    echo "</td>";
    echo "</tr>\n";
}

?>
</table>

</div>
</div>



<!-- Loan Data -->
<div class="panel panel-success">

    <div class="panel-heading"><?= $t->__('db.lend') ?>:</div>
   <div class="panel-body">

       <form method="post" action="bookLendConfirmation.php">
           <input type="hidden" name="book_id"   value="<?=$book_id?>"   />
           <input type="hidden" name="person_id" value="<?=$person_id?>" id="person_id_for_loan"/>
    <script>
        $(function() {
            $( "#datepicker" ).datepicker({ dateFormat: "dd/mm/yy" });
        });
    </script>
    
    <table style="border-spacing: 5px; border-collapse: separate;">

      <tr>
        <td width="1%"><strong><?= $t->__('db.lend.date_lend') ?>:</strong></td>
        <td><input type="text" name="date_lend" size="10" value="<?= date('d/m/Y', time()); ?>" id="datepicker"/></td>
      </tr>

      <tr>
        <td><?= $t->__('db.lend.notes') ?>:</td>
        <td>
            <textarea rows="6" cols="47" name="notes" autofocus></textarea>
        </td>
      </tr>
    
      <tr>
        <td></td>
        <td>
            <input type="submit" class="btn btn-default" value="<?= $t->__('button.confirmLend') ?>" id='loan_data_submit_button' disabled=true/>
            <input type="button" class="btn btn-default" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='bookSearch.php'"/>
        </td>
      </tr>
        
    </table>

      
       </form>
   </div>

</div>


    
<?php include '_footer.php' ?>
