<?php
  
  ////
  // atwork/day.php
  
  require_once '../system/init.php';
  
  $sql = 'SELECT * FROM atwork WHERE user = ? AND start <= ? AND finish >= ?';
  $stmt = $db->prepare($sql);
  $stmt->execute(array($_SESSION['user'], $_POST['d'], $_POST['d']));
//  print_r($stmt->fetchAll());

?>
<form action="#" method="post" id="timeform">
  <input type="hidden" id="date" name="date" value="<?= $_POST['d']; ?>"/>
  <table>
    <thead>
      <tr>
        <th style="width:150px">Saapuminen</th>
        <th style="width:150px">Lähtö</th>
      </tr>
    </thead>
    <tbody>
    
<?php foreach(range(0, 4) as $r): ?>
    
<tr>
  <td>
    <select name="start-h[<?= $r; ?>]" class="start_h">
      <option>--</option>
          
<?php foreach(range(8, 23) as $h): ?>
    
      <option><?= sprintf('%02d', $h); ?></option>
    
<?php endforeach ?>

    </select>
    :
    <select name="start-m[<?= $r; ?>]" class="start_m">
      <option>--</option>
          
<?php foreach(range(0, 3) as $m): ?>
          
      <option><?= sprintf('%02d', $m*15); ?></option>
          
<?php endforeach ?>
          
    </select>
    </td>
    <td>
      <select name="finish-h[<?= $r; ?>]" class="finish_h">
        <option>--</option>
          
<?php foreach(range(8, 23) as $h): ?>

        <option><?= sprintf('%02d', $h); ?></option>

<?php endforeach ?>

        </select>
        :
        <select name="finish-m[<?= $r; ?>]" class="finish_m">
          <option>--</option>
          
<?php foreach(range(0, 3) as $m): ?>

          <option><?= sprintf('%02d', $m*15); ?></option>

<?php endforeach ?>
        
      </td>
    </tr>
    
<?php endforeach ?>
    
    <tr>
      <td colspan="2"><strong>Merkinnät</strong>
      <br/>
      <textarea name="notes" rows="8" cols="40"></textarea></td>
    </tr>
    
  </tbody>
</table>
</form>