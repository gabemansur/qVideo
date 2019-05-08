<?php

class Log {

  private $file;
  private $filepath;

  function __construct(){
    $this->filepath = getcwd().'/logs/log.txt';
    // If the log file doesn't exist, create it
     if(!file_exists($this->filepath)) {
       $this->createLogFile();
     }
     // If the log file is over 25mb, archive it and start a new one
     if(filesize($this->filepath) > 25000000) {
       $this->archiveLog();
     }
  }

  public function write($str) {
    $d = date('Y-m-d:H:i:s').':: ';
    file_put_contents($this->filepath, $d.$str."\n", FILE_APPEND | LOCK_EX);

  }

  private function createLogFile(){
    $this->file = fopen($this->filepath, "w");
    fclose($this->file);
  }

  private function archiveLog() {
    $date = date('m-d-Y');
    rename($this->filepath, uniqid().$date.'txt');
    $this->createLogFile();
  }
}

?>
