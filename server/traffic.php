<?PHP

  $cmd = 'test';
  $num = '4165621384';
  $msg = '401 - 38mins; 407 - 29mins';
  
  $sub = "Traffic to work";
  $frm = "pebble@traffic.php";
  $hdr = "From: ".$frm;

  print "try json";
  $json  = file_get_contents('https://maps.googleapis.com/maps/api/directions/json?origin=10+Fawnridge+Trail,+Scarborough&destination=1+commerce+valley+dr+markham&units=metric');
  print "process json";
//  $traffic = process_traffic($json);
print "done processing json";
//  print json_encode($traffic);

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
function curl_get($url){
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/1.0");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function process_traffic($json_in) {
    $json_output = json_decode(utf8_decode($json_in));
    if (!$json_output) die(); 

    $result = "abc";
/*    $traffic     = $json_output->traffic;
    $temp        = $json_output->main->temp;
    $icon        = $traffic[0]->icon;

    $result    = array();
    $result[1] = $icon;
    $result[2] = array('I', round($temp, 0));
*/
    return $result;
}

/***************************************************************
https://maps.googleapis.com/maps/api/directions/json?origin=10+Fawnridge+Trail,+Scarborough&destination=1+commerce+valley+dr+markham&units=metric

https://maps.googleapis.com/maps/api/directions/json?origin=10+Fawnridge+Trail,+Scarborough&destination=1+commerce+valley+dr+markham&waypoints=via:43.892649,%20-79.186464&units=metric
***************************************************************/
?>

