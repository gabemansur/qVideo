<?php

class Log {

  private $file;
  const FILEPATH = '/logs/log.txt';

  function __construct(){
    // If the log file doesn't exist, create it
     if(!file_exists(self::FILEPATH)) {
       $this->createLogFile();
     }
     // If the log file is over 25mb, archive it and start a new one
     if(filesize($this->file) > 25000000) {
       $this->archiveLog();
     }
  }

  public function write($str) {
    $d = date('Y-m-d:H:i:s').':: ';
    file_put_contents($dself::FILEPATH, $d.$str.'\n', FILE_APPEND | LOCK_EX);

  }

  private function createLogFile(){
    $this->file = fopen(self::FILEPATH, "a");
    fclose($this->file);
  }

  private function archiveLog() {
    $date = date('m-d-Y');
    rename(self::FILEPATH, uniqid().$date.'txt');
    $this->createLogFile();
  }
}

?>
