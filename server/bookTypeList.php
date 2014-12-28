<?php include '_header.php' ?>
    
<h1><?= $t->__('bookTypeList.title') ?></h1>

<form method="post">
  <input type="button" value="<?= $t->__('button.new') ?>" onclick="window.location.href='bookType.php'" />
</form>

<br/>

<table border=1 cellpadding="5" cellspacing="0">
    <tr>
        <th><?= $t->__('db.type.name') ?></th>
        <th><?= $t->__('label.action') ?></th>
    </tr>
<?php

$datas = $database->select("tb_type", "*");

foreach($datas as $row) {
    $counter++;
    $fmw->escapeHtmlArray($row);
    echo "<tr>";
    echo "<td>";
    echo "<a href='bookType.php?id=" . $row['id'] . "'>" . $row['name'] . '</a>';
    echo "</td>";
    echo "<td>";
    echo "<a href='bookTypeAction.php?action=delete&id=" . $row['id'] . "'>". $t->__('label.action.delete') ."</a>";
    echo "</td>";
    echo "</tr>\n";
}

?>

</table>


<?php include '_footer.php' ?>
