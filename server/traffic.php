<?PHP

/***************************************
  if (!isset($_GET['cmd'])) die();
  if (!isset($_GET['frm'])) die();
  if (!isset($_GET['num'])) die();
  if (!isset($_GET['msg'])) die();

  $cmd = $_GET['cmd'];
  $frm = $_GET['frm'];
  $num = $_GET['num'];
  $msg = $_GET['msg'];
***************************************/
  $cmd = 'test';
  $num = '4165621384';
  $msg = '401 - 38mins; 407 - 29mins';
  
  $sub = "Traffic to work";
  $frm = "pebble@traffic.php";
  $hdr = "From: ".$frm;

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

?>

