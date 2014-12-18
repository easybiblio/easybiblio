<?php
  include '_header.php';

  $book_id = $_GET['book_id'];
  if ($book_id != '') {
    $book_columns = $database->get("tb_book", "*", array("id" => $book_id));
    $fmw->escapeHtmlArray($book_columns);
  }
?>

<h1><?= $t->__('bookLend.title') ?></h1>

<?= $t->__('db.book') ?>:
<table width="70%" border="1" cellpadding="5" cellspacing="0">
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


<br/>
<br/>
<?= $t->__('db.person') ?>:
<?php
    $search_string = $_POST['search_person'];
    if (!isset($search_string)) {
        $search_string = $_SESSION['search_person'];
    } else {
        $_SESSION['search_person'] = $search_string;
    }
    $search_string = trim($search_string);
?>
<form method="post">
    <input type="search" name="search_person" value="<?= $fmw->escapeHtml($search_string) ?>" autofocus/>
    <input type="submit" value="<?= $t->__('button.search') ?>"/>
    <input type="button" value="<?= $t->__('button.newPerson') ?>" onclick="window.location.href='person.php'" />
</form>

<br/>




<form method="post" action="bookLendConfirmation.php">

<input type="hidden" name="book_id" value="<?=$book_id?>" />
    
<table border=1 cellpadding="5" cellspacing="0">
    <tr>
        <th></th>
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
    echo "<input type='radio' name='person_id' value='" . $row['id'] . "' />";
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


<br/>

    <script>
        $(function() {
            $( "#datepicker" ).datepicker({ dateFormat: "dd/mm/yy" });
        });
    </script>
    
    <table width="70%" cellpadding="5" border="0">

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
        <td colspan="2">
            <input type="submit" value="<?= $t->__('button.confirmLend') ?>"/>
            <input type="button" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='bookSearch.php'"/>
        </td>
       </tr>
    </table>
    
</form>
    
<?php include '_footer.php' ?>
