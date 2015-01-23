<?php include '_header.php' ?>
    
<h1><?= $t->__('bookCoverSearch.title') ?></h1>

<?php
    $search_string = $_POST['search_book'];
    $onlyWithoutCover = $_POST['onlyWithoutCover'] === "true";
    if (!isset($search_string)) {
        $search_string = $_SESSION['search_book'];
        $onlyWithoutCover = $_SESSION['onlyWithoutCover'];
    } else {
        $_SESSION['search_book'] = $search_string;
        $_SESSION['onlyWithoutCover'] = $onlyWithoutCover;
    }
    $search_string = trim($search_string);
?>
<form class="navbar-form navbar-left" role="search" method="post">
    <input type="search"   class="form-control" name="search_book"      value="<?= $fmw->escapeHtml($search_string) ?>" autofocus/>
    <div class="checkbox">
    <label><input type="checkbox" name="onlyWithoutCover" value="true" <?= $onlyWithoutCover ? "checked" : "" ?> >&nbsp;<?= $t->__('bookCoverSearch.label.withoutCover') ?></label>
    </div>
    <input type="submit"   class="btn btn-default" value="<?= $t->__('button.search') ?>"/>
</form>

<br/>

<table class="table table-hover">
    <tr>
        <th><?= $t->__('db.book.code') ?></th>
        <th><?= $t->__('db.book.cover') ?></th>
        <th><?= $t->__('db.book.title') ?></th>
        <th><?= $t->__('label.action') ?></th>
    </tr>
<?php

$search_string = strtr($search_string, " ", "%");
$search_string_quoted = $database->quote("%".$search_string."%");
$filterCover = $onlyWithoutCover ? "(cover_url = '' or cover_url is NULL)" : "true";
$query = "select tb_book.*, !isnull(tb_lend.id) as lended, tb_lend.id as lend_id, tb_type.name as typeName " .
           "from (select * from tb_book where " . $filterCover . " and (code like ".$search_string_quoted." or title like ".$search_string_quoted." or author like ".$search_string_quoted." or coauthor like ".$search_string_quoted.") order by code) tb_book ".
           "left join (select id, book_id from tb_lend where date_return is null) tb_lend on tb_book.id = tb_lend.book_id " .
           "left join tb_type on tb_book.type_id = tb_type.id";

$datas = $database->query($query)->fetchAll();

$counter = 0;
foreach($datas as $row) {
    $counter++;
    $fmw->escapeHtmlArray($row);
    if ($row['lended']) {
        echo "<tr class='lended'>";
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
    
    // Upload cover
    echo "<td>";
    echo "<form action='bookCoverUpload.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='hidden' name='bookId' value='" . $row['id'] . "' />";
    echo "<input type='file' name='uploadFile' onchange='javascript:this.form.submit();' />";
    echo "</form>"; 
    echo "</td>";
    
    echo "</tr>\n";
    if ($counter == 10) {
        echo "<tr><td colspan='100' align='center'>";
        echo $t->__('message.there_are_more_books');
        echo "</td></tr>";
        break;
    }
}

?>

</table>


<?php include '_footer.php' ?>
