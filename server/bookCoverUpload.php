<?php require_once '_header.mandatory.php';

$fmw->checkOperator();

/**
 * This function resize a JPG Image
 */
function fix_image($file, $file_type) {
        //This line reads the EXIF data and passes it into an array
        $exif = read_exif_data($file);

        //We're only interested in the orientation
        $exif_orient = isset($exif['Orientation'])?$exif['Orientation']:0;
        $rotateImage = 0;

        //We convert the exif rotation to degrees for further use
        if (6 == $exif_orient) {
            $rotateImage = 90;
            $imageOrientation = 1;
        } elseif (3 == $exif_orient) {
            $rotateImage = 180;
            $imageOrientation = 1;
        } elseif (8 == $exif_orient) {
            $rotateImage = 270;
            $imageOrientation = 1;
        }

        //if the image is rotated
        if ($rotateImage) {

            //WordPress 3.5+ have started using Imagick, if it is available since there is a noticeable difference in quality
            //Why spoil beautiful images by rotating them with GD, if the user has Imagick

            if (class_exists('Imagick')) {
                $imagick = new Imagick();
                $imagick->readImage($file);
                $imagick->rotateImage(new ImagickPixel(), $rotateImage);
                $imagick->setImageOrientation($imageOrientation);
                $imagick->writeImage($file);
                $imagick->clear();
                $imagick->destroy();
            } else {

                //if no Imagick, fallback to GD
                //GD needs negative degrees
                $rotateImage = -$rotateImage;

                switch ($file_type) {
                    case 'image/jpeg':
                        $source = imagecreatefromjpeg($file);
                        $rotate = imagerotate($source, $rotateImage, 0);
                        imagejpeg($rotate, $file);
                        break;
                    case 'image/png':
                        $source = imagecreatefrompng($file);
                        $rotate = imagerotate($source, $rotateImage, 0);
                        imagepng($rotate, $file);
                        break;
                    case 'image/gif':
                        $source = imagecreatefromgif($file);
                        $rotate = imagerotate($source, $rotateImage, 0);
                        imagegif($rotate, $file);
                        break;
                    default:
                        break;
                }
            }
        }
        // The image orientation is fixed
    }


$bookId = $_POST['bookId'];
if (!is_numeric($bookId)) {
    $fmw->error('bookCoverUpload.message.bookNotFound');
    header("Location: bookCoverSearch.php");
    exit();
}

// Creating folders
if (!file_exists('images')) {
  mkdir('images');
}
if (!file_exists('images/covers')) {
  mkdir('images/covers');
}

$target_dir = "images/covers/book_cover_" . $bookId . '.jpg';

// Check file size
if ($uploadFile_size > 500000) {
    $fmw->error('bookCoverUpload.message.fileTooBig');
}

// Only JPG files allowed
$uploadfile_type = $_FILES['uploadFile']['type'];
if (!($uploadfile_type == "image/jpeg")) {
    $fmw->error('bookCoverUpload.message.wrongFileType', $uploadfile_type);
}

// Check if file already exist, lets remove it
if (!$fmw->hasError() && file_exists($target_dir)) {
    unlink($target_dir);
}

// Check if $uploadOk is set to 0 by an error
if (!$fmw->hasError()) {
    if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_dir)) {
        fix_image($target_dir, 'image/jpeg');
        
        // Making sure browser ignores previous cached image, as a new one is being saved now.
        $target_dir = $target_dir . '?' . time();
        
        $columns = array(
            "cover_url" => $target_dir
        );

        $database->update("tb_book", $columns, array("id[=]" => $bookId));  

        $fmw->checkDatabaseError();
        
        $fmw->info('bookCoverUpload.message.success');
    } else {
        $fmw->error('bookCoverUpload.message.error');
    }
}

header("Location: bookCoverSearch.php");
?>