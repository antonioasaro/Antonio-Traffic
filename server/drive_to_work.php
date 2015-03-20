<?PHP

  $cmd = 'test';
  $num = '4165621384@sms.rogers.com';
  $msg = '';
  
  $sub = "Traffic to work";
  $frm = "pebble@traffic.php";
  $hdr = "From: ".$frm;

  $json = file_get_contents('https://api.tomtom.com/routing/1/calculateRoute/43.79539,-79.17098:43.83888,-79.37971/json?maxAlternatives=0&routeType=fastest&traffic=true&key=ya7xukdn8cdsyzppnv2ertav', 0, null, null);
  $traffic = process_traffic($json);
  $msg = "Hwy 401: " . $traffic[0] . " km - " . $traffic[1] . " mins";

  $json = file_get_contents('https://api.tomtom.com/routing/1/calculateRoute/43.79539,-79.17098:43.882876,-79.182163:43.83888,-79.37971/json?maxAlternatives=0&routeType=fastest&traffic=true&key=ya7xukdn8cdsyzppnv2ertav', 0, null, null);
  $traffic = process_traffic($json);
  $msg = $msg . "; Hwy 407: " . $traffic[0] . " km - " . $traffic[1] . " mins";
  $msg = $msg . "                                                         ";

  $sentOK = 0;
  $d = date("D");
  if (($d=="Mon") || ($d=="Tue") || ($d=="Wed") || ($d=="Thu") || ($d=="Fri")) {
    if (strcmp($cmd, "send") == 0) {
      if (mail($num, $sub, $msg, $hdr)) { $sentOK = 1; }
    } else {
      if (strcmp($cmd, "test") == 0) {
////        print "<b>To:</b> ".$num."<br><b>From:</b> ".$frm."<br><b>Subject:</b> ".$sub."<br><b>Msg:</b> ".$msg."<br><br>";
        print $msg;
      }
    }
  }
  $result[1] = array();
  $result[1] = array('I', $sentOK);
////  print json_encode($result);


/*************************************************/
function process_traffic($json_in) {
    $json_out = json_decode($json_in);
    if (!$json_out) die(); 
    $distance = $json_out->routes[0]->summary->lengthInMeters;
    $duration = $json_out->routes[0]->summary->travelTimeInSeconds;

    $results = array(ceil($distance/1000*10)/10, ceil($duration/60*10)/10);
    return $results;
}

?>

