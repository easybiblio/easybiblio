<?php require_once '_header.mandatory.php' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>NEECAFLA - Bibliotheque</title>
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="jquery-ui/jquery-ui.css">
    <script src="jquery-ui/external/jquery/jquery.js"></script>
    <script src="jquery-ui/jquery-ui.js"></script>
</head>
    
<body>
    
<table border = "0" style="border-spacing:10px;">
    <tr>
        <td>
            <img src="logoNeecafla_officiel_inter.jpg" />
        </td>
        <td>
            <h2>Notre Bibliothèque</h2>
            Tous les samedi de 16h au 17h. <br/>
            Le 1er et 3ème lundi du mois de 18h30 au 19h00.<br/>
            Une grande collections de livres Spirites pour vous preter !
        </td>
    </tr>
</table>
    
<a href="bookSearch.php">Chercher&nbsp;livres</a>&nbsp;&nbsp;
<a href="personSearch.php">Chercher&nbsp;personnes</a>&nbsp;&nbsp;
<a href="reportBookLended.php">Livres&nbsp;empruntés</a>&nbsp;&nbsp;
<a href="reportStatistics.php">Statistiques</a>
    
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
		<strong>Erreur:</strong> <?= $fmw->escapeHtml($message) ?></p>
	</div>
</div>
 <?php }  ?>