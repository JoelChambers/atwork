<?php

  ////
  // atwork/month.php
  
  require_once '../system/init.php';
  
  // Get month total
  $sql = "SELECT SUM(strftime('%s', finish)-strftime('%s', start)) AS thesum
  FROM atwork
  WHERE user = ?
  AND strftime('%m', start) = ?";
  
  $stmt_tot = $db->prepare($sql);
  
  // Get total hours for each day
  $sql = "SELECT strftime('%s', finish) - strftime('%s', start) AS done
  FROM atwork
  WHERE user = ?
  AND date(finish) = ?";
  
  $stmt = $db->prepare($sql);
  
  if (!$_POST['m']) {
    $_SESSION['m'] = date('n');
  }
  
  $_SESSION['m'] = $_SESSION['m'] + $_POST['m'];
  $month = sprintf('%02d', $_SESSION['m']);
  $stmt_tot->execute(array($_SESSION['user'], $month));
  $total = current($stmt_tot->fetchAll());
  $first = mktime(0, 0, 0, $_SESSION['m'], 0);
  $last = mktime(0, 0, 0, $_SESSION['m']+1, 0);
  $days = ($last-$first)/3600/24;

?>

  <img src="images/cal_16.png" class="icon" alt=""/>
  <h2><?= date('F Y', $last); ?> (<?= $total['thesum']/3600; ?>h)</h2>

<?php
  
    foreach(range(1, $days) as $d):
      
      $current = $first+3600*24*$d;
      $txt = date('D, d', $current);
      $stmt->execute(array($_SESSION['user'], date('Y-m-d', $current)));
      $tmp = current($stmt->fetchAll());
      $work = $tmp['done']/3600;
      
?>
  
  <div class="day" title="<?= date('d.m.Y', $current); ?>">
    <?= $txt; ?>
    <div class="hours"><?= $work; ?>h</div>
  </div>

<?php endforeach ?>
