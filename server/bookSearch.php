<?php include '_header.php' ?>
    
<h1><?= $t->__('bookSearch.title') ?></h1>

<?php
    $search_string = $_POST['search_book'];
    if (!isset($search_string)) {
        $search_string = $_SESSION['search_book'];
    } else {
        $_SESSION['search_book'] = $search_string;
    }
    $search_string = trim($search_string);
?>
<form class="navbar-form navbar-left" role="search" method="post">
    
<div class="input-group">
  <input type="text" class="form-control" name="search_book" value="<?= $fmw->escapeHtml($search_string) ?>" autofocus/>
  <span class="input-group-btn">
    <input type="submit" class="btn btn-default" value="<?= $t->__('button.search') ?>"/>

    <?php if ($fmw->isLoggedInContributor()) { ?>
    <input type="button" class="btn btn-default" value="<?= $t->__('button.new') ?>" onclick="window.location.href='book.php'" />
    <?php } ?>
  </span>
</div>
    

</form>

<br/>

<table class="table table-hover">
    <tr>
        <th><?= $t->__('db.book.code') ?></th>
        <th><?= $t->__('db.book.cover') ?></th>
        <th><?= $t->__('db.book.title') ?></th>
        <th><?= $t->__('db.book.author') ?></th>
        <th><?= $t->__('db.book.coauthor') ?></th>
        <th><?= $t->__('db.book.type') ?></th>
        <?php if ($fmw->isLoggedInOperator()) { ?>
        <th><?= $t->__('label.action') ?></th>
        <?php } ?>
    </tr>
<?php

$search_string = strtr($search_string, " ", "%");
$search_string_quoted = $database->quote("%".$search_string."%");
$query = "select tb_book.*, !isnull(tb_lend.id) as lended, tb_lend.id as lend_id, tb_type.name as typeName " .
           "from (select * from tb_book where code like ".$search_string_quoted." or title like ".$search_string_quoted." or author like ".$search_string_quoted." or coauthor like ".$search_string_quoted." order by date_creation desc) tb_book ".
           "left join (select id, book_id from tb_lend where date_return is null) tb_lend on tb_book.id = tb_lend.book_id " .
           "left join tb_type on tb_book.type_id = tb_type.id";

$datas = $database->query($query)->fetchAll();

$counter = 0;
foreach($datas as $row) {
    $counter++;
    $fmw->escapeHtmlArray($row);
    if ($row['lended']) {
        echo "<tr class='success'>";
    } else {
        echo "<tr>";
    }
    echo "<td>";
    echo $row['code'];
    echo "</td>";
    
    // Existing cover
    echo "<td>";
    if ($row['cover_url'] != '') {
        $img_src_nocache = $fmw->escapeHtml($row['cover_url']) . '?' . time();
        echo "<img src='".$img_src_nocache."' width='150'/>";
    }
    echo "</td>";
    
    echo "<td>";
    echo "<a href='book.php?id=" . $row['id'] . "'>" . $row['title'] . '</a>';
    echo "</td>";
    echo "<td>";
    echo $row['author'];
    echo "</td>";
    echo "<td>";
    echo $row['coauthor'];
    echo "</td>";
    echo "<td>";
    echo $row['typeName'];
    echo "</td>";
    
    if ($fmw->isLoggedInOperator()) {
        echo "<td>";
        if ($row['lended']) {
            echo "<a href='bookReturn.php?lend_id=" . $row['lend_id'] . "'>" . $t->__('label.action.return') . '</a>';
        } else {
            echo "<a href='bookLend.php?book_id=" . $row['id'] . "'>" . $t->__('label.action.lend') . '</a>';
        }
        echo "</td>";
    }
    
    echo "</tr>\n";
    if ($counter == 20) {
        echo "<tr><td colspan='100' align='center'>";
        echo $t->__('message.there_are_more_books');
        echo "</td></tr>";
        break;
    }
}

?>

</table>


<?php include '_footer.php' ?>
