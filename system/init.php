<?php
  
  ////
  // atwork/init.php
  
  error_reporting(E_ALL|E_STRICT);
  ini_set('display_errors', 'on');

  date_default_timezone_set('Europe/Helsinki');
  setlocale(LC_ALL, 'fi_FI');

  session_start();
  $_SESSION['user'] = 'filipp';

  $basedir = realpath(__FILE__ . '/../../');
  $db = new PDO("sqlite:{$basedir}/system/atwork.db");

?>
