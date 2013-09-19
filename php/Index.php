<?php 

$url = "";
session_start();

if(isset($_POST['submit']) && (($_POST['link']) != ""))
{
  $_SESSION['text'] = $_POST['link'];
  header("Location: ". $_SERVER['REQUEST_URI']);
  exit;
}
else
{
  if(isset($_SESSION['text']))
  {
    $url = $_SESSION['text'];
    unset($_SESSION['text']);
  }
}
?>

<!DOCTYPE html>

<head>
<title>Check Web Status</title>
</head>
<body>
<br/><h2> Hello </h2>

<?php

function Visit($url){
  $agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
  $ch=curl_init();
  curl_setopt ($ch, CURLOPT_URL,$url );
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($ch,CURLOPT_VERBOSE,false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch,CURLOPT_SSLVERSION,3);
  curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
  $page=curl_exec($ch);
  //echo curl_error($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  if($httpcode>=200 && $httpcode<400) return true;
  else return false;
}
function Print_Form()
{
  echo "<h3> Enter a webpage and see whether it's up </h3></p>";
  echo "<form  method=\"post\">";
  echo "<p>URL: <input type=\"text\" name=\"link\" /></p>";
  echo "<p><input type=\"submit\" name=\"submit\" value=\"check\" />";
  echo "</form>";
}

if($url != "")
{
  if (Visit($url))
  {  Print_Form();
       echo "<br> <h3> Website '$url' is UP Now </h3>";
  }
  else
  {  Print_Form();
       echo "<br> <h3> Website '$url' is DOWN </h3>";
  }
}
else
{
  Print_Form();
} 
?>

</body>
</html>
