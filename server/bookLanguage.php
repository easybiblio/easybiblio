<?php include '_header.php' ?>

<h1><?= $t->__('db.language') ?></h1>

<?php
  $language = $_GET['language'];
  if ($language != '') {
    $columns = $database->get("tb_language", "*", array("language" => $language));
  }
?>

<form action="bookLanguageAction.php?action=save" method="post">


<!-- isCreate -->
<?php if (!isset($language)) { 
    $isCreate = true; ?>

    <input type="hidden" name="isCreate" value="true" />
    
<?php } else { ?>
    
    <input type="hidden" name="isCreate" value="false" />
    <input type="hidden" name="language" value="<?= $language ?>" />
    
<?php } ?>


<table width="70%" border="0">

  <tr>
    <td width="10%"><strong><?= $t->__('db.language.language') ?>:</strong></td>
    <td><input type="text" name="language" value=<?= $fmw->getPostOrArrayQuoted($columns, 'language') ?> size="52" maxlength="2" <?= $isCreate ? "" : "disabled" ?> /></td>
  </tr>
    
  <tr>
    <td width="10%"><strong><?= $t->__('db.language.language_name') ?>:</strong></td>
    <td><input type="text" name="language_name" value=<?= $fmw->getPostOrArrayQuoted($columns, 'language_name') ?> size="52" maxlength="45"></td>
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
      <input type="button" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='bookLanguageList.php'"></td>
  </tr>

</table>

</form>

<?php include '_footer.php' ?>