<?php require_once '_header.mandatory.php' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyBiblio</title>
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    
    <script src="jquery-ui/external/jquery/jquery.js"></script>
    <script src="jquery-ui/jquery-ui.js"></script>
</head>
    
<body>
    
 <nav class="navbar navbar-default navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="bookSearch.php"><span class="glyphicon glyphicon-book"> EasyBiblio</span></a>
    </div>

    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <?= strpos($_SERVER["REQUEST_URI"], 'bookSearch.php') ? "<li class='active'>" : "<li>" ?>
          <a href="bookSearch.php"><?= $t->__('menu.search_book') ?></a>
        </li>
        
        <?php if ($fmw->isLoggedInOperator()) { ?>
            <?= strpos($_SERVER["REQUEST_URI"], 'personSearch.php') ? "<li class='active'>" : "<li>" ?>
              <a href="personSearch.php"><?= $t->__('menu.search_people') ?></a>
            </li>

            <?= strpos($_SERVER["REQUEST_URI"], 'reportBookLended.php') ? "<li class='active'>" : "<li>" ?>
              <a href="reportBookLended.php"><?= $t->__('menu.lent_book') ?></a>
            </li>
        <?php } ?>
     
         <?php if ($fmw->isLoggedInAdmin() || $fmw->isLoggedInOperator()) {
             $url = $_SERVER["REQUEST_URI"];
             $adminActive = false;
             $adminActive = $adminActive || strpos($url, 'userList.php');
             $adminActive = $adminActive || strpos($url, 'bookCategoryList.php');
             $adminActive = $adminActive || strpos($url, 'bookTypeList.php');
             $adminActive = $adminActive || strpos($url, 'bookLanguageList.php');
             $adminActive = $adminActive || strpos($url, 'bookCoverSearch.php');
             $adminActive = $adminActive || strpos($url, 'reportStatistics.php'); ?>
    
            <li class="dropdown <?= $adminActive ? "active" : "" ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  <?= $t->__('menu.admin') ?> <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">

                <?php if ($fmw->isLoggedInAdmin()) { ?>
                <?= strpos($_SERVER["REQUEST_URI"], 'userList.php') ? "<li class='active'>" : "<li>" ?>
                  <a href="userList.php"><?= $t->__('menu.admin.userList') ?></a>
                </li>
                <?php } ?>
                  
                <?= strpos($_SERVER["REQUEST_URI"], 'bookCategoryList.php') ? "<li class='active'>" : "<li>" ?>
                  <a href="bookCategoryList.php"><?= $t->__('menu.admin.bookCategory') ?></a>
                </li>

                <?= strpos($_SERVER["REQUEST_URI"], 'bookTypeList.php') ? "<li class='active'>" : "<li>" ?>
                  <a href="bookTypeList.php"><?= $t->__('menu.admin.bookType') ?></a>
                </li>

                <?= strpos($_SERVER["REQUEST_URI"], 'bookLanguageList.php') ? "<li class='active'>" : "<li>" ?>
                  <a href="bookLanguageList.php"><?= $t->__('menu.admin.bookLanguage') ?></a>
                </li>

                <?= strpos($_SERVER["REQUEST_URI"], 'bookCoverSearch.php') ? "<li class='active'>" : "<li>" ?>
                  <a href="bookCoverSearch.php"><?= $t->__('menu.admin.bookCover') ?></a>
                </li>

                <?= strpos($_SERVER["REQUEST_URI"], 'reportStatistics.php') ? "<li class='active'>" : "<li>" ?>
                  <a href="reportStatistics.php"><?= $t->__('menu.admin.statistics') ?></a>
                </li>

                <?= strpos($_SERVER["REQUEST_URI"], 'backup.php') ? "<li class='active'>" : "<li>" ?>
                  <a href="backup.php"><?= $t->__('menu.admin.backup') ?></a>
                </li>

              </ul>
            </li>

        <?php } ?>
     
     

        <?php if (!$fmw->isLoggedIn()) { ?>

            <li>
              <a href="login.php"><?= $t->__('menu.login') ?></a>
            </li>

        <?php } else { ?>

            <li>
              <a href="logout.php"><?= $t->__('menu.logout') ?></a>
            </li>

        <?php } ?>
     

      </ul>
      <ul class="nav navbar-nav navbar-right">

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              <span class="glyphicon glyphicon-globe"></span>
          </a>
          <ul class="dropdown-menu" role="menu">

            <?php
             // Getting all possible languages
             $possible_languages = array_diff(scandir('lang'), array('..', '.'));
             foreach($possible_languages as $language) {
                 $language = substr($language, 0, strpos($language, '.'));
                 echo "<li>", "<a href='' onClick=\"javascript:_changeLanguage('", $language ,"')\">", $language, "</a></li>";
             }
            ?>

          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>


<?php
 $message = $_SESSION['message'];
 if ($message != '') {?>
    <div class="alert alert-warning">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?= $fmw->escapeHtml($message) ?>
    </div>
<?php } ?>
    
<?php
 $message = $_SESSION['error_message'];
 if ($message != '') {?>
    <div class="alert alert-danger" role="alert">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
      <?= $fmw->escapeHtml($message) ?>
    </div>
 <?php }  ?>