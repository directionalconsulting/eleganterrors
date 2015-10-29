<?php

	require('share/inc/globals.php');

	# PITA -- PHP issues a warning without this function call.
	date_default_timezone_set($GLOBALS[TIME_ZONE]);
	$date = date("c", time());
	$referer = $_SERVER[HTTP_REFERER];
	$remote  = $_SERVER["REMOTE_ADDR"];
	$trip = "On date $date, referered $referer, for $remote\n";
	file_put_contents("tripwire.log", $trip, FILE_APPEND);

?>
<html>
<head>
<title></title>
<meta http-equiv="refresh" content="11; url=http://www.contractorsthriftstore.com/">

<SCRIPT language="JavaScript"> 
<!--
function getgoing()  {
    top.location="http://www.contractorsthriftstore.com";
}
//--> 
</SCRIPT> 

</head>
<body>
<center>
<table width=60% cellpadding=3 cellspacing=6>
<tr><td colspan=2 bgcolor=beige>
<p>
<center><h1>YOU ARE AT</h1></center>
<p>
</td></tr>
<tr><td bgcolor=beige>
<a href=http://www.contractorsthriftstore.com/>
<img border=0 src=http://www.contractorsthriftstore.com/img/cts1-50g.png>
<img border=0 src=http://www.contractorsthriftstore.com/img/cts2-50g.png>
</a>
You will be redirected in 10 seconds.<br>
</td><td rowspan=2 bgcolor=yellow>
<center><h2>Advertise Here</h2></center>
</td></tr>
<tr><td bgcolor=lightblue>
<center><h2>Google Ads Here</h2></center>
</td></tr>
</table>
</center>

<SCRIPT language="JavaScript"> 
<!--

     setTimeout('getgoing()',10000);

//--> 
</SCRIPT> 

</body>
</html>