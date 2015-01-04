<?php include '_header.php' ?>
<?php include '_menuAdmin.php' ?>
    
<h1><?= $t->__('bookTypeList.title') ?></h1>

<form method="post">
  <input type="button" value="<?= $t->__('button.new') ?>" onclick="window.location.href='bookType.php'" />
</form>

<br/>

<table class="table table-hover">
    <tr>
        <th><?= $t->__('db.type.id') ?></th>
        <th><?= $t->__('db.type.name') ?></th>
        <th><?= $t->__('label.numberOfBooks') ?></th>
        <th><?= $t->__('label.action') ?></th>
    </tr>
<?php

$datas = $database->select("tb_type", "*");

foreach($datas as $row) {
    $fmw->escapeHtmlArray($row);
    
    $id = $row['id'];
    $numberBooks = $database->count("tb_book", array("type_id[=]" => $id));
    
    echo "<tr>";
    echo "<td>", $id, "</td>";
    echo "<td>";
    echo "<a href='bookType.php?id=" . $id . "'>" . $row['name'] . '</a>';
    echo "</td>";
    echo "<td>", $numberBooks, "</td>";
    echo "<td>";
    echo "<a href='bookTypeAction.php?action=delete&id=" . $id . "'>". $t->__('label.action.delete') ."</a>";
    echo "</td>";
    echo "</tr>\n";
}

?>

</table>


<?php include '_footer.php' ?>
