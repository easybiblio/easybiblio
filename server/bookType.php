<?php
  include_once '_header.mandatory.php';
  $fmw->checkOperator();
  include '_header.php';
?>

<h1><?= $t->__('db.type') ?></h1>

<?php
  $id = $_GET['id'];
  if ($id != '') {
    $columns = $database->get("tb_type", "*", array("id" => $id));
  }
?>

<form action="bookTypeAction.php?action=save" method="post">

<!-- ID -->
<input type="hidden" name="id" value="<?= $columns['id'] ?>">

<table width="70%" border="0">

  <tr>
    <td width="10%"><strong><?= $t->__('db.type.name') ?>:</strong></td>
    <td><input type="text" name="name" value=<?= $fmw->getPostOrArrayQuoted($columns, 'name') ?> size="52" maxlength="120"></td>
  </tr>
    
  <!-- Ligne vide -->
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <!-- Buttons -->
  <tr> 
    <td>&nbsp;</td>
    <td align="left" class="texte"> 
      <input type="submit" name="Submit" value="<?= $t->__('button.save') ?>">
      <input type="button" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='bookTypeList.php'"></td>
  </tr>

</table>

</form>

<?php include '_footer.php' ?>