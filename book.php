<?php include '_header.php' ?>

<h1>Livres</h1>

<?php
  $id = $_GET['id'];
  if (!isset($id)) {
    $id = $_POST['id'];
  }
  if ($id != '') {
    $columns = $database->get("tb_book", "*", array('id' => $id));
  } else {
    $columns = array();
    $columns['language'] = 'pt'; // Default value
  }

  function prepareLanguageOptions($valueToSelect) {
      global $database;
      $data = $database->select("tb_language", '*');
      foreach ($data as $row) {
          echo "\n<option value=";
          echo $database->quote($row['language']);
          echo $valueToSelect == $row['language'] ? "selected" : "";
          echo ">";
          echo $row['language_name'];
          echo "</option>";
      }
  }

  function prepareCategoryOptions($valueToSelect) {
      global $database;
      $data = $database->select("tb_category", '*');
      foreach ($data as $row) {
          echo "\n<option value=";
          echo $database->quote($row['id']);
          echo $valueToSelect == $row['id'] ? "selected" : "";
          echo ">";
          echo $row['name'];
          echo "</option>";
      }
  }

  function prepareTypeOptions($valueToSelect) {
      global $database;
      $data = $database->select("tb_type", '*');
      foreach ($data as $row) {
          echo "\n<option value=";
          echo $database->quote($row['id']);
          echo $valueToSelect == $row['id'] ? "selected" : "";
          echo ">";
          echo $row['name'];
          echo "</option>";
      }
  }

?>

<form action="bookSave.php" method="post">

<!-- ID -->
<input type="hidden" name="id" value="<?= $id ?>">

<table width="70%" border="0">

  <!-- Code -->
  <tr>
    <td width="10%"><strong>Code:</strong></td>
    <td><input type="text" name="code" value=<?= $fmw->getPostOrArrayQuoted($columns, 'code') ?> size="52" maxlength="45"></td>
  </tr>

  <!-- Type -->
  <tr>
    <td>Type:</td>
    <td>
    <select name="type_id" size="1">
        <?php prepareTypeOptions( $fmw->getPostOrArray($columns, 'type_id') ); ?>
	</select>
    </td>
  </tr>
    
  <!-- Title -->
  <tr>
    <td><strong>Titre:</strong></td>
    <td> 
      <input type="text" name="title" value=<?= $fmw->getPostOrArrayQuoted($columns, 'title') ?> size="52" maxlength="100"></td>
  </tr>
  
  <tr>
    <td>Description:</td>
    <td>
        <textarea rows="6" cols="47" name="description"><?= $fmw->escapeHtml($fmw->getPostOrArray($columns, 'description')) ?></textarea>
    </td>
  </tr>
    
  <!-- Author -->
  <tr>
    <td>Auteur:</td>
    <td> 
      <input type="text" name="author" value=<?= $fmw->getPostOrArrayQuoted($columns, 'author') ?> size="52" maxlength="100"></td>
  </tr>
  
  <!-- CoAuthor -->
  <tr>
    <td>Esprit:</td>
    <td><input type="text" name="coauthor" value=<?= $fmw->getPostOrArrayQuoted($columns, 'coauthor') ?> size="52" maxlength="100"></td>
  </tr>
  
  <!-- Editor -->
  <tr>
    <td>Editeur:</td>
    <td><input type="text" name="editor" value=<?= $fmw->getPostOrArrayQuoted($columns, 'editor') ?> size="52" maxlength="100"></td>
  </tr>
 
  <!-- Year of publication -->
  <tr>
    <td>Année publication:</td>
    <td><input type="number" name="year_publication" value=<?= $fmw->getPostOrArrayQuoted($columns, 'year_publication') ?> size="52" maxlength="4"></td>
  </tr>
  

  <!-- Language -->
  <tr>
    <td>Langue:</td>
    <td>
        <select name="language" size="1">
            <?php prepareLanguageOptions( $fmw->getPostOrArray($columns, 'language') ); ?>
	    </select>
    </td>
  </tr>
    
  <!-- Category -->
  <tr>
    <td>Categorie:</td>
    <td>
    <select name="category_id" size="1">
        <?php prepareCategoryOptions( $fmw->getPostOrArray($columns, 'category_id') ); ?>
	</select>
    </td>
  </tr>
    
  <tr>
    <td>Notes:</td>
    <td>
        <textarea rows="6" cols="47" name="notes"><?= $fmw->escapeHtml($fmw->getPostOrArray($columns, 'notes')) ?></textarea>
    </td>
  </tr>
    
   <?php if ($id != '') { ?>
  <tr>
    <td>Date&nbsp;Creation:</td>
    <td><?= $fmw->getPostOrArray($columns, 'date_creation') ?></td>
  </tr>
  <?php } ?>

  <!-- Ligne vide -->
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <!-- Buttons -->
  <tr> 
    <td>&nbsp;</td>
    <td align="left" class="texte"> 
      <input type="submit" name="Submit" value="Sauvegarder">
      <input type="button" value="Annuler" onclick="window.location.href='bookSearch.php'" ></td>
  </tr>


</table>

</form>

<?php include '_footer.php' ?>