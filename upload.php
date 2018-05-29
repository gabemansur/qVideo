<?php
require('driveup.php');
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

$fileName = $_FILES['media']['name'];
$fileSize = $_FILES['media']['size'];
$fileTmpName  = $_FILES['media']['tmp_name'];
$fileType = $_FILES['media']['type'];

$uploadPath = $currentDir . $uploadDirectory . $_POST['u'] .'_' . uniqid() .'.webm';

$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                $result = uploadToDrive($uploadPath);
                if($result['name'] == basename($uploadPath)) {
                  unlink($uploadPath);
                }
                else echo 'Error saving file to server';
            } else {
                echo 'Error uploading file';
            }
?>
