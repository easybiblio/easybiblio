<?php
  include_once '_header.mandatory.php';
  $fmw->checkOperator();
  include '_header.php';
?>
    
<h1><?= $t->__('auditSearch.title') ?></h1>

<?php
    $start_date = date("d/m/Y",strtotime("-1 month"));
    $post_date = $_POST['start_date'];
    $session_date = $_SESSION['audit_start_date'];
    if (!isset($post_date) and isset($session_date)) {
        $start_date = $session_date;
    } else if (isset($post_date) and $fmw->verifyDate($post_date)) {
        $start_date = $post_date;
    }
    $_SESSION['audit_start_date'] = $start_date;
    
    $end_date = date('d/m/Y');
    $post_date = $_POST['end_date'];
    $session_date = $_SESSION['audit_start_end'];
    if (!isset($post_date) and isset($session_date)) {
        $end_date = $session_date;
    } else if (isset($post_date) and $fmw->verifyDate($post_date)) {
        $end_date = $post_date;
    }
    $_SESSION['audit_end_date'] = $end_date;
?>

<form class="navbar-form navbar-left" role="search" method="post">

    <script>
        $(function() {
            $( "#start_date" ).datepicker({ dateFormat: "dd/mm/yy" });
            $( "#end_date" ).datepicker({ dateFormat: "dd/mm/yy" });
        });
    </script>
    
    <label class="control-label"><?= $t->__('auditSearch.label.start_date') ?>:</label>
    <input type="text" name="start_date" size="10" class="form-control" value="<?= $start_date ?>" id="start_date"/>

    <label class="control-label"><?= $t->__('auditSearch.label.end_date') ?>:</label>
    <input type="text" name="end_date" size="10" class="form-control" value="<?= $end_date ?>" id="end_date"/>

    <input type="submit" class="btn btn-default" value="<?= $t->__('button.search') ?>"/>

</form>

<br/>

<table class="table table-hover">
    <tr>
        <th><?= $t->__('db.audit.timestamp') ?></th>
        <th><?= $t->__('db.audit.username') ?></th>
        <th><?= $t->__('db.audit.operation') ?></th>
        <th><?= $t->__('db.audit.details') ?></th>
    </tr>
<?php

$query = "select * from tb_audit where STR_TO_DATE('".$start_date."','%d/%m/%Y') < timestamp and timestamp <= STR_TO_DATE('".$end_date." 23:59:59','%d/%m/%Y %H:%i:%s')";

$datas = $database->query($query)->fetchAll();

$counter = 0;
foreach($datas as $row) {
    $counter++;
    $fmw->escapeHtmlArray($row);

    echo "<tr>";
    
    echo "<td>";
    echo $row['timestamp'];
    echo "</td>";

    echo "<td>";
    echo $row['username'];
    echo "</td>";

    echo "<td>";
    echo $row['operation'];
    echo "</td>";
    
    echo "<td>";
    echo $row['details'];
    echo "</td>";
    
    echo "</tr>\n";
    if ($counter == 100) {
        echo "<tr><td colspan='100' align='center'>";
        echo $t->__('message.there_are_more');
        echo "</td></tr>";
        break;
    }
}

?>

</table>

<?php include '_footer.php' ?>
