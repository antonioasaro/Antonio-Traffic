<?PHP

  $cmd = 'send';
  $num = '4165621384@sms.rogers.com';
  $msg = '';
  
  $sub = "Traffic to work";
  $frm = "pebble@traffic.php";
  $hdr = "From: ".$frm;

  $json = file_get_contents('http://www.mapquestapi.com/directions/v2/route?key=Fmjtd%7Cluurnu6bnd%2Cr5%3Do5-9wbggr&outFormat=json&routeType=fastest&timeType=1&locale=en_US&unit=k&from=10%20Fawnridge%20Trail%20Scarborough%20canada&to=1%20commerce%20valley%20east%20markham%20canada', 0, null, null);
  $traffic = process_traffic($json);
  $msg = "Hwy 401: " . $traffic;

/*
  $json = file_get_contents('https://maps.googleapis.com/maps/api/directions/json?origin=10+Fawnridge+Trail,+Scarborough&destination=1+commerce+valley+dr+markham&units=metric', 0, null, null);
  $traffic = process_traffic($json);
  $msg = $msg . "; Hwy 407: " . $traffic . ".";
*/

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

    $results = ceil($distance*10)/10 . " km - " . ceil($duration/60*10)/10 . " mins";
    return $results;
}

/***************************************************************
http://www.mapquestapi.com/directions/v2/route?key=Fmjtd%7Cluurnu6bnd%2Cr5%3Do5-9wbggr&callback=renderAdvancedNarrative&ambiguities=ignore&avoidTimedConditions=false&doReverseGeocode=true&outFormat=json&routeType=fastest&timeType=1&enhancedNarrative=false&shapeFormat=raw&generalize=0&locale=en_US&unit=m&from=10%20Fawnridge%20Trail%20Scarborough%20canada&to=1%20commerce%20valley%20east%20markham%20canada

https://maps.googleapis.com/maps/api/directions/json?origin=10+Fawnridge+Trail,+Scarborough&destination=1+commerce+valley+dr+markham&units=metric

https://maps.googleapis.com/maps/api/directions/json?origin=10+Fawnridge+Trail,+Scarborough&destination=1+commerce+valley+dr+markham&waypoints=via:43.892649,%20-79.186464&units=metric
***************************************************************/
?>

