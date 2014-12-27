<?php include '_header.php' ?>

<script>

function loadImage() {
    var imgToLoad = $("#cover_url").val();

	var img = $("<img/>")
	.load(function(e) {
		$("#imageContainer").replaceWith(e.target);
	})
    .attr("id","imageContainer")
    .attr("width", 260)
	.attr("src",imgToLoad);
}

</script>

<h1><?= $t->__('db.book') ?></h1>

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

<table>
<tr><td>
<table width="70%" border="0">

  <!-- Code -->
  <tr>
    <td width="10%"><strong><?= $t->__('db.book.code') ?>:</strong></td>
    <td><input type="text" name="code" value=<?= $fmw->getPostOrArrayQuoted($columns, 'code') ?> size="52" maxlength="45"></td>
  </tr>

  <!-- Type -->
  <tr>
    <td><?= $t->__('db.book.type') ?>:</td>
    <td>
    <select name="type_id" size="1">
        <?php prepareTypeOptions( $fmw->getPostOrArray($columns, 'type_id') ); ?>
	</select>
    </td>
  </tr>
    
  <!-- Title -->
  <tr>
    <td><strong><?= $t->__('db.book.title') ?>:</strong></td>
    <td> 
      <input type="text" name="title" value=<?= $fmw->getPostOrArrayQuoted($columns, 'title') ?> size="52" maxlength="100"></td>
  </tr>
  
  <tr>
    <td><?= $t->__('db.book.description') ?>:</td>
    <td>
        <textarea rows="6" cols="47" name="description"><?= $fmw->escapeHtml($fmw->getPostOrArray($columns, 'description')) ?></textarea>
    </td>
  </tr>
    
  <!-- Author -->
  <tr>
    <td><?= $t->__('db.book.author') ?>:</td>
    <td> 
      <input type="text" name="author" value=<?= $fmw->getPostOrArrayQuoted($columns, 'author') ?> size="52" maxlength="100"></td>
  </tr>
  
  <!-- CoAuthor -->
  <tr>
    <td><?= $t->__('db.book.coauthor') ?>:</td>
    <td><input type="text" name="coauthor" value=<?= $fmw->getPostOrArrayQuoted($columns, 'coauthor') ?> size="52" maxlength="100"></td>
  </tr>
  
  <!-- Editor -->
  <tr>
    <td><?= $t->__('db.book.editor') ?>:</td>
    <td><input type="text" name="editor" value=<?= $fmw->getPostOrArrayQuoted($columns, 'editor') ?> size="52" maxlength="100"></td>
  </tr>
 
  <!-- Year of publication -->
  <tr>
    <td><?= $t->__('db.book.year_publication') ?>:</td>
    <td><input type="number" name="year_publication" value=<?= $fmw->getPostOrArrayQuoted($columns, 'year_publication') ?> size="52" maxlength="4"></td>
  </tr>
  

  <!-- Language -->
  <tr>
    <td><?= $t->__('db.book.language') ?>:</td>
    <td>
        <select name="language" size="1">
            <?php prepareLanguageOptions( $fmw->getPostOrArray($columns, 'language') ); ?>
	    </select>
    </td>
  </tr>
    
  <!-- Category -->
  <tr>
    <td><?= $t->__('db.book.category') ?>:</td>
    <td>
    <select name="category_id" size="1">
        <?php prepareCategoryOptions( $fmw->getPostOrArray($columns, 'category_id') ); ?>
	</select>
    </td>
  </tr>
    
  <tr>
    <td><?= $t->__('db.book.notes') ?>:</td>
    <td>
        <textarea rows="6" cols="47" name="notes"><?= $fmw->escapeHtml($fmw->getPostOrArray($columns, 'notes')) ?></textarea>
    </td>
  </tr>
    
   <?php if ($id != '') { ?>
  <tr>
    <td><?= $t->__('db.book.date_creation') ?>:</td>
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
      <input type="submit" name="Submit" value="<?= $t->__('button.save') ?>">
      <input type="button" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='bookSearch.php'" ></td>
  </tr>


</table>
</td>

<?php
  // Making sure that image does not get cached by the browser.
  $img_src_nocache = $fmw->getPostOrArray($columns, 'cover_url');
  $img_src_nocache = "'" . $fmw->escapeHtml($img_src_nocache) . '?' . time() . "'";
?>

<td style="vertical-align:top">
<?= $t->__('db.book.cover') ?><br/>
<input id='cover_url' type="text" name="cover_url" value=<?= $fmw->getPostOrArrayQuoted($columns, 'cover_url') ?> size="52" onInput="loadImage();"/><br/><br/>
<img id='imageContainer' src=<?= $img_src_nocache ?> width= "260" />
</td>

    
</tr></table>

</form>

<?php include '_footer.php' ?>