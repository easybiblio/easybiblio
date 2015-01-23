<?php include '_header.php' ?>
    
<h1><?= $t->__('bookCategoryList.title') ?></h1>

<form method="post">
  <input type="button" value="<?= $t->__('button.new') ?>" onclick="window.location.href='bookCategory.php'" />
</form>

<br/>

<table class="table table-hover">
    <tr>
        <th><?= $t->__('db.category.id') ?></th>
        <th><?= $t->__('db.category.name') ?></th>
        <th><?= $t->__('label.numberOfBooks') ?></th>
        <th><?= $t->__('label.action') ?></th>
    </tr>
<?php

$datas = $database->select("tb_category", "*");

foreach($datas as $row) {
    $fmw->escapeHtmlArray($row);
    
    $id = $row['id'];
    $numberBooks = $database->count("tb_book", array("category_id[=]" => $id));

    echo "<tr>";
    echo "<td>", $id, "</td>";
    echo "<td>";
    echo "<a href='bookCategory.php?id=" . $id . "'>" . $row['name'] . '</a>';
    echo "</td>";
    echo "<td>", $numberBooks, "</td>";
    echo "<td>";
    echo "<a href='bookCategoryAction.php?action=delete&id=" . $id . "'>". $t->__('label.action.delete') ."</a>";
    echo "</td>";
    echo "</tr>\n";
}

?>

</table>


<?php include '_footer.php' ?>
