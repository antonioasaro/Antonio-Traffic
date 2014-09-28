<?PHP

  $cmd = 'send';
  $num = '4165621384@sms.rogers.com';
  $msg = '';
  
  $sub = "Traffic to work";
  $frm = "pebble@traffic.php";
  $hdr = "From: ".$frm;

  $json = file_get_contents('https://maps.googleapis.com/maps/api/directions/json?origin=10+Fawnridge+Trail,+Scarborough&destination=1+commerce+valley+dr+markham&units=metric', 0, null, null);
  $traffic = process_traffic($json);
  $msg = "401: " . $traffic;

  $json = file_get_contents('https://maps.googleapis.com/maps/api/directions/json?origin=10+Fawnridge+Trail,+Scarborough&destination=1+commerce+valley+dr+markham&waypoints=via:43.892649,%20-79.186464&units=metric', 0, null, null);
  $traffic = process_traffic($json);
  $msg = $msg . "; 407: " . $traffic;

  $sentOK = 0;
  if (strcmp($cmd, "send") == 0) {
      if (mail($num, $sub, $msg, $hdr)) { $sentOK = 1; }
  } else {
      if (strcmp($cmd, "test") == 0) {
        print "<b>To:</b> ".$num."<br><b>From:</b> ".$frm."<br><b>Subject:</b> ".$sub."<br><b>Msg:</b> ".$msg."<br><br>";
    }
  }
  $result[1] = array();
  $result[1] = array('I', $sentOK);
  print json_encode($result);


/*************************************************/
function process_traffic($json_in) {
    $json_out = json_decode($json_in);
    if (!$json_out) die(); 
    $distance = $json_out->routes[0]->legs[0]->distance->text;
    $duration = $json_out->routes[0]->legs[0]->duration->text;

    $result = $distance . " - " . $duration;
    return $result;
}

/***************************************************************
https://maps.googleapis.com/maps/api/directions/json?origin=10+Fawnridge+Trail,+Scarborough&destination=1+commerce+valley+dr+markham&units=metric

https://maps.googleapis.com/maps/api/directions/json?origin=10+Fawnridge+Trail,+Scarborough&destination=1+commerce+valley+dr+markham&waypoints=via:43.892649,%20-79.186464&units=metric
***************************************************************/
?>

