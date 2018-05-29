<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('driveup.php');

function runUploadTest() {

  $filePath = getcwd().'/uploads/testblob.webm';
  $r = uploadToDrive($filePath);
  echo '<pre>';
  print_r($r);
  echo '</pre>';
  if($r['name'] == basename($filePath)) {
    echo 'SUCCESS!';
  }
  else {
    echo 'FAIL?';
  }
}

// Tests to run
runUploadTest();
