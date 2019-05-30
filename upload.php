<?php
require('driveup.php');
require('logger.php');
/* FOR MULTIPLE MEDIA FILES
foreach(array('video', 'audio') as $type) {
    if (isset($_FILES["${type}-blob"])) {

        echo 'uploads/';

        $fileName = $_POST["${type}-filename"];
        $uploadDirectory = 'uploads/'.$fileName;

        if (!move_uploaded_file($_FILES["${type}-blob"]["tmp_name"], $uploadDirectory)) {
            echo(" problem moving uploaded file");
        }

        echo($fileName);
    }
}
*/

$currentDir = getcwd();
$uploadDirectory = "/uploads/";
$log = new Log();

$fileName = $_FILES['media']['name'];
$fileSize = $_FILES['media']['size'];
$fileTmpName  = $_FILES['media']['tmp_name'];
$fileType = $_FILES['media']['type'];

$uploadPath = $currentDir . $uploadDirectory . $_POST['u'] .'_' . uniqid() .'.webm';

$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                $log->write('Uploaded '.$uploadPath.' to server. Attempting to upload to Drive');
                $result = uploadToDrive($uploadPath);
                if($result['name'] == basename($uploadPath)) {
                  $log->write('Uploaded '.$uploadPath.' to Drive');
                  unlink($uploadPath);
                  echo 'Success';
                }
                else {
                  $log->write('Error saving '.$uploadPath.' to Drive');
                  echo 'Error saving file to server';
                }
            } else {
                $log->write('Error uploading '.$uploadPath.' to server');
                echo 'Error uploading file';
            }
?>
