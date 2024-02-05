<!DOCTYPE html>
<html lang="en">
<head>
	<title>DNS status</title>
	<meta content="text/html" charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<style>
pre {
    overflow-x: auto;
	max-width: 60vw;
}

pre code {
    word-wrap: normal;
    white-space: pre;
}
	</style>
</head>
<html><div class="container">
<?php

$data = "";
$data .= '
<div class="card my-2">
  <h4 class="card-header text-center">
    DNS status
  </h4>
  <div class="card-body pb-0">
';


//configure script
$timeout = "1";

//set service checks
/* 
The script will open a socket to the following service to test for connection.
Does not test the fucntionality, just the ability to connect
Each service can have a name, port and the Unix domain it run on (default to localhost)
*/
$services = array();


$services[] = array("port" => "53",       "service" => "DNS Aruba 1",                  "ip" => "ns.abdns.biz") ;
$services[] = array("port" => "53",       "service" => "DNS Aruba 2",                  "ip" => "ns.abdns.eu") ;
$services[] = array("port" => "53",       "service" => "DNS Aruba 3",                  "ip" => "ns.abdns.info") ;


//begin table for status
$data .= "<small><table  class='table table-striped table-sm '><thead><tr><th>Service</th><th>Port</th><th>Status</th></tr></thead>";
foreach ($services  as $service) {
	if($service['ip']==""){
	   $service['ip'] = "localhost";
	}
	$data .= "<tr><td>" . $service['service'] . "</td><td>". $service['port'];

	$fp = @fsockopen($service['ip'], $service['port'], $errno, $errstr, $timeout);
	if (!$fp) {
		$data .= "</td><td class='table-danger'>Offline </td></tr>";
	  //fclose($fp);
	} else {
		$data .= "</td><td class='table-success'>Online</td></tr>";
		fclose($fp);
	}

}  
//close table
$data .= "</table></small>";
$data .= '
  </div>
</div>
';
echo $data;

?>
</div></html>
