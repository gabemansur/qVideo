<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('driveup.php');

function runUploadTest() {
  print 'RUNNING UPLOAD TO DRIVE TEST...<br>';
  $filePath = getcwd().'/uploads/testblob.webm';
  $r = uploadToDrive($filePath);
  echo '<pre>';
  print_r($r);
  echo '</pre>';
  if($r['name'] == basename($filePath)) {
    print 'UPLOAD TO DRIVE - PASSED<br>';
  }
  else {
    print 'UPLOAD TO DRIVE - FAILED<br>';
  }
}

function canWriteTest() {
  print 'RUNNING CAN WRITE TO UPLOAD FOLDER TEST...<br>';
  $url = $filePath = getcwd().'/uploads';
  if (!is_writable($url)) {

        try {
            chmod($url, 0644);
        } catch (Exception $e) {
            print $e->getMessage() . ' | File : ' . $url . ' | Needs write permission [0644] to process !<br>';
            print 'CAN WRITE TO UPLOAD FOLDER - FAILED<br>';
        }
        print 'CAN WRITE TO UPLOAD FOLDER - PASSED<br>';
    }
  else {
    print 'CAN WRITE TO UPLOAD FOLDER - PASSED<br>';
  }
}

// Tests to run
canWriteTest();
runUploadTest();
