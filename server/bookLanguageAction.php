<?php require_once '_header.mandatory.php';

$fmw->checkOperator();

$action = $_GET['action'];

if ($action == 'delete') {

    $language = $_GET['language'];
    $numberBooks = $database->count("tb_book", array("language[=]" => $language));

    if ($numberBooks > 0) {
        $fmw->info('bookLanguageDelete.message.notPossibleToDelete', $numberBooks);
    } else {
        $deleted = $database->delete("tb_language", array("language[=]" => $language));

        if ($deleted > 0) {
            $fmw->info('bookLanguageDelete.message.deleted');
        } else {
            $fmw->info('bookLanguageDelete.message.notFound');
        }
    }
    
} else if ($action == 'save') {
    
    $language = trim($_POST['language']);
    $language_name = trim($_POST['language_name']);
    if ($language == '' || $language_name == '') {
        $fmw->error('bookLanguageSave.message.mandatory');
        include('bookLanguage.php');
        exit();
    }

    $isCreate = $_POST['isCreate'];
    if ($isCreate == 'false') {
        
        $columns = array(
            "language_name" => $language_name
        );
        
        $database->update("tb_language", $columns, array("language[=]" => $language));
        $fmw->info('bookLanguageSave.message.updated');

    } else {
        
        // For creation, language should always be lowercase.
        $language = strtolower($language);  
        $alreadyExist = $database->count("tb_language", array("language[=]" => $language));
        
        if ($alreadyExist >= 1) {
            $fmw->error('bookLanguageSave.message.alreadyExist');
            include('bookLanguage.php');
            exit();
        }
        
        $columns = array(
            "language" => $language,
            "language_name" => $language_name
        );
        
        $database->insert("tb_language", $columns); 
        $fmw->info('bookLanguageSave.message.created');
    }
    
}


$fmw->checkDatabaseError();

header("Location: bookLanguageList.php");
?>