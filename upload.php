<?php
require('dbx.php');
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
$fileExtension = strtolower(end(explode('.',$fileName)));

$uploadPath = $currentDir . $uploadDirectory . $_POST['u'] .'_' . uniqid() .'.webm';

$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                echo "The file " . basename($fileName) . " has been uploaded";
                moveToDBX($uploadPath);
            } else {
                echo "An error occurred somewhere. Try again or contact the admin";
            }
?>
