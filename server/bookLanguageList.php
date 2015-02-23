<?php
  include_once '_header.mandatory.php';
  $fmw->checkOperator();
  include '_header.php';
?>
    
<h1><?= $t->__('bookLanguageList.title') ?></h1>

<form method="post">
  <input type="button" value="<?= $t->__('button.new') ?>" onclick="window.location.href='bookLanguage.php'" />
</form>

<br/>

<table class="table table-hover">
    <tr>
        <th><?= $t->__('db.language.language') ?></th>
        <th><?= $t->__('db.language.language_name') ?></th>
        <th><?= $t->__('label.numberOfBooks') ?></th>
        <th><?= $t->__('label.action') ?></th>
    </tr>
<?php

$datas = $database->select("tb_language", "*");

foreach($datas as $row) {
    $fmw->escapeHtmlArray($row);
    
    $language = $row['language'];
    $numberBooks = $database->count("tb_book", array("language[=]" => $language));

    echo "<tr>";
    echo "<td>", $language, "</td>";
    echo "<td>";
    echo "<a href='bookLanguage.php?language=" . $language . "'>" . $row['language_name'] . '</a>';
    echo "</td>";
    echo "<td>", $numberBooks, "</td>";
    echo "<td>";
    echo "<a href='bookLanguageAction.php?action=delete&language=" . $language . "'>". $t->__('label.action.delete') ."</a>";
    echo "</td>";
    echo "</tr>\n";
}

?>

</table>


<?php include '_footer.php' ?>
