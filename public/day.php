<?php
  
  ////
  // atwork/day.php
  
  require_once '../system/init.php';
  
  $tmp = explode('.', $_POST['d']);
  $date = sprintf('%d-%02d-%02d', $tmp[2], $tmp[1], $tmp[0]);
  
  // Find this day
  $sql = "SELECT * FROM atwork WHERE user = ?
  AND date(?) BETWEEN date(start) AND date(finish);";
  $stmt = $db->prepare($sql);
  $stmt->execute(array($_SESSION['user'], $date));
  $day = $stmt->fetchAll();
  $day = array_pad($day, 5, array());

?>

<form action="#" method="post" id="timeform">
  <input id="date" name="date" type="hidden" value="<?= $_POST['d']; ?>"/>
  <table>
    <thead>
      <tr>
        <th style="width:150px">Saapuminen</th>
        <th style="width:150px">Lähtö</th>
      </tr>
    </thead>
    <tbody>
    
<?php

  foreach(range(0, 4) as $r):
    
    $start = @date_parse($day[$r]['start']);
    $finish = @date_parse($day[$r]['finish']);

?>
    
      <tr>
        <td>
          <select name="start-h[<?= $r; ?>]" class="start_h">
            <option>--</option>
          
<?php

  foreach(range(8, 23) as $h):
    
    $selected = ($h == $start['hour']) ? 'selected="selected"' : '';
  
?>
    
            <option <?= $selected; ?>><?= sprintf('%02d', $h); ?></option>
    
<?php endforeach ?>

        </select>
        :
        <select name="start-m[<?= $r; ?>]" class="start_m">
          <option>--</option>
          
<?php

  foreach(range(0, 3) as $m):
    
    $min = sprintf('%02d', $m*15);
    $selected = ($min == $start['minute']) ? 'selected="selected"' : '';
    
?>
          
          <option <?= $selected; ?>><?= $min; ?></option>
          
<?php endforeach ?>
          
        </select>
      </td>
      <td>
        <select name="finish-h[<?= $r; ?>]" class="finish_h">
          <option>--</option>
          
<?php
  
  foreach(range(8, 23) as $h):
    
    $selected = ($h == $finish['hour']) ? 'selected="selected"' : '';
    
?>

          <option <?= $selected; ?>><?= sprintf('%02d', $h); ?></option>
          
<?php endforeach ?>
          
        </select>
        :
        <select name="finish-m[<?= $r; ?>]" class="finish_m">
          <option>--</option>
          
<?php

  foreach(range(0, 3) as $m):
  
    $min = sprintf('%02d', $m*15);
    $selected = ($min == $finish['minute']) ? 'selected="selected"' : '';
    
?>

          <option <?= $selected; ?>><?= $min; ?></option>

<?php endforeach ?>
        
      </td>
    </tr>
    
<?php endforeach ?>
    
    <tr>
      <td colspan="2">
        <select style="width:368px" name="type" id="type">
          <option>--</option>
          <option value="1">Töissä</option>
          <option value="2">Etätöissä</option>
          <option value="3">Sairaana</option>
          <option value="4">Ylityövapaalla</option>
          <option value="5">Koulutuksessa</option>
          <option value="6">Vuosilomalla</option>
          <option value="7">Isyys/äitiyslomalla</option>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2">Merkinnät<br/>
      <textarea name="notes" rows="2" cols="40"></textarea></td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="checkbox" id="lunch" name="lunch" value="1"/> Lounastauko
      </td>
    </tr>
  </tbody>
</table>
</form>