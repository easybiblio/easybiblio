<?php
  include_once '_header.mandatory.php';
  $fmw->checkOperator();
  include '_header.php';
?>
    
<h1><?= $t->__('reportBookLended.title') ?></h1>

<?php
    $query = "select *, tb_lend.id as lend_id, tb_lend.notes as notes, tb_book.code as book_code, DATEDIFF(now(), date_lend) as late_days ".
               "from (select * from tb_lend where date_return is null) tb_lend left join tb_book ".
                "on tb_lend.book_id = tb_book.id left join tb_person on tb_lend.person_id = tb_person.id order by date_lend";

    $datas = $database->query($query)->fetchAll();
?>

<table class="table table-hover">
    <tr>
        <th><?= $t->__('db.lend.date_lend') ?></th>
        <th><?= $t->__('reportBookLended.label.days') ?></th>
        <th><?= $t->__('db.book') ?></th>
        <th><?= $t->__('db.person') ?></th>
        <th><?= $t->__('db.person.phone1') ?></th>
        <th><?= $t->__('db.person.phone2') ?></th>
        <th><?= $t->__('db.person.email') ?></th>
        <th><?= $t->__('db.lend.notes') ?></th>
        <th><?= $t->__('label.action') ?></th>
    </tr>
<?php

$counter = 0;
foreach($datas as $row) {
    $counter++;
    $fmw->escapeHtmlArray($row);
    echo "<tr>";
    echo "<td>";
    echo $row['date_lend'];
    echo "</td>";
    echo "<td>";
    echo $row['late_days'];
    echo "</td>";
    echo "<td>";
    echo "<a href='book.php?id=" . $row['book_id'] . "'>(" . $row['book_code'] . ') ' . $row['title'] . '</a>';
    echo "</td>";
    echo "<td>";
    echo "<a href='person.php?id=" . $row['person_id'] . "'>" . $row['name'] . '</a>';
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
    echo "<td>";
    echo $row['notes'];
    echo "</td>";
    echo "<td>";
    echo "<a href='bookLendEditNotes.php?lend_id=" . $row['lend_id'] . "'>" . $t->__('reportBookLended.action.change_notes') . '</a>';
    echo "&nbsp;&nbsp;&nbsp";
    echo "<a href='bookReturn.php?lend_id=" . $row['lend_id'] . "'>" . $t->__('reportBookLended.action.return') . '</a>';
    echo "</td>";
    echo "</tr>\n";
}

?>

</table>

<br/>
<?= $t->__('reportBookLended.message.total_lent_books') ?>: <?=$counter?>

<?php include '_footer.php' ?>
