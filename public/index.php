<?php
  
  ////
  // atwork/index.php
  
  require_once '../system/init.php';
  
  if (!empty($_POST['date']))
  {
    $format = '%d-%02d-%02d %02d:%02d';
    $date = explode('.', $_POST['date']);
    // First we check if we insert or update
    
    $sql = 'INSERT INTO atwork (user, start, finish) VALUES (?, ?, ?)';
    $stmt = $db->prepare($sql);
    
    foreach($_POST['start-h'] as $k => $h_start)
    {
      if($h_start != '--')
      {
        $m_start = $_POST['start-m'][$k];
        $start = sprintf($format, $date[2], $date[1], $date[0], $h_start, $m_start);
        $h_finish = $_POST['finish-h'][$k];
        $m_finish = $_POST['finish-m'][$k];
        $finish = sprintf($format, $date[2], $date[1], $date[0], $h_finish, $m_finish);
        $stmt->execute(array($_SESSION['user'], $start, $finish));
      }
    }
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <script src="js/jquery-1.4.2.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="js/jquery-ui-1.8.custom.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="js/atwork.js" type="text/javascript" charset="utf-8"></script>
  
	<style type="text/css" media="screen">
    @import url('css/cupertino/jquery-ui-1.8.custom.css');
    @import url('css/screen.css');
  </style>
	
	<title>@work</title>
	
</head>

<body>

<div id="page">
  <div id="dialog" style="display:none"></div>
  
  <div id="header">
    <a href="#" id="previous">Edellinen kuukausi</a>
    <a href="#" id="now">Tämä kuukausi</a>
    <a href="#" id="today">Tämä päivä</a>
    <a href="#" id="print">Tulosta kuukausi</a>
    <a href="#" id="refresh">Uudista näkymä</a>
    <a href="#" id="next">Seuraava kuukausi</a>
  </div>
  
  <div id="month"></div>
  
</div>

</body>
</html>
