<?PHP

  $cmd = 'send'; // 'test';
  $num = '4165621384@sms.rogers.com';
  $msg = '';
  
  $sub = "Traffic to work";
  $frm = "pebble@traffic.php";
  $hdr = "From: ".$frm;

  $json = file_get_contents('http://www.mapquestapi.com/directions/v2/route?key=Fmjtd%7Cluurnu6bnd%2Cr5%3Do5-9wbggr&outFormat=json&routeType=fastest&timeType=1&locale=en_US&unit=k&from=43.795434,-79.170746&to=43.839313,-79.379755', 0, null, null);
  $traffic = process_traffic($json);
  $msg = "Hwy 401: " . $traffic[0] . " km - " . $traffic[1] . " mins";

  $json = file_get_contents('http://www.mapquestapi.com/directions/v2/route?key=Fmjtd%7Cluurnu6bnd%2Cr5%3Do5-9wbggr&outFormat=json&routeType=fastest&timeType=1&locale=en_US&unit=k&from=43.795434,-79.170746&to=43.882876,%20-79.182163', 0, null, null);
  $waypoint = process_traffic($json);
  $json = file_get_contents('http://www.mapquestapi.com/directions/v2/route?key=Fmjtd%7Cluurnu6bnd%2Cr5%3Do5-9wbggr&outFormat=json&routeType=fastest&timeType=1&locale=en_US&unit=k&from=43.882876,-79.182163&to=43.839313,-79.379755', 0, null, null);
  $traffic = process_traffic($json);
  $msg = $msg . "; Hwy 407: " .  ($waypoint[0]+$traffic[0]) . " km - " . ($waypoint[1]+$traffic[1]) . " mins.";
  $msg = $msg . "                                                         ";

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
    $distance = $json_out->route->distance;
    $duration = $json_out->route->realTime;

    $results = array(ceil($distance*10)/10, ceil($duration/60*10)/10);
    return $results;
}

?>

