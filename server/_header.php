<?php require_once '_header.mandatory.php' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>EasyBiblio</title>
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="jquery-ui/jquery-ui.css">
    <script src="jquery-ui/external/jquery/jquery.js"></script>
    <script src="jquery-ui/jquery-ui.js"></script>
    
    <script>
        function _changeLanguage(languageToSet) {
           $.get("_changeLanguage.php?_language=" + languageToSet, function(data,status) {
              alert('language was set, reload URL here');
           });
        }
    </script>
    
</head>
    
<body>

<div style="position: absolute; top: 5px; right: 80px;">
    <img src="http://www.easybiblio.com/wp-content/themes/camp/images/default-image.jpg" height="80" />
</div>
<div style="position: absolute; top: 30px; right: 100px;">
    <span style="color: white; font-size:27px;">EasyBiblio Demo Site</span>
</div>
  
<div id="changeLanguage" style="position: absolute; top: 10px; right: 5px;">
<?php
 // Getting all possible languages
 $possible_languages = array_diff(scandir('lang'), array('..', '.'));
 foreach($possible_languages as $language) {
     $language = substr($language, 0, strpos($language, '.'));
     echo "<a href='' onClick=\"javascript:_changeLanguage('", $language ,"')\">", $language, "</a><br/>";
 }
?>
</div>
    
<a href="bookSearch.php"><?= $t->__('menu.search_book') ?></a>&nbsp;&nbsp;
<a href="personSearch.php"><?= $t->__('menu.search_people') ?></a>&nbsp;&nbsp;
<a href="reportBookLended.php"><?= $t->__('menu.lent_book') ?></a>&nbsp;&nbsp;
<a href="reportStatistics.php"><?= $t->__('menu.statistics') ?></a>&nbsp;&nbsp;&nbsp;&nbsp;

<?php
 $message = $_SESSION['message'];
 if ($message != '') {?>
<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<?= $fmw->escapeHtml($message) ?></p>
	</div>
</div>
 <?php } ?>
    
<?php
 $message = $_SESSION['error_message'];
 if ($message != '') {?>
    <br/> <br/>
<div class="ui-widget">
	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<?= $fmw->escapeHtml($message) ?></p>
	</div>
</div>
 <?php }  ?>