<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Loading</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="css/loading.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/aa9a352006.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
  <div class="row">
  	<div class="col align-self-center">
  		<h1 class="h2">One moment please, <br> the data is being loaded.</h1>
  	</div>
      <div class="loader"></div>
    
    
  </div>
</div>
</body>
</html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './vendor/autoload.php';

use lepiaf\SerialPort\SerialPort;
use lepiaf\SerialPort\Parser\SeparatorParser;
use lepiaf\SerialPort\Configure\TTYConfigure;
$temp = "";
$humi = "";
$press = "";
$light = "";

$configure = new TTYConfigure();
$configure->removeOption("9600");
$configure->setOption("115200");

$serialPort = new SerialPort(new SeparatorParser("\n"), $configure);
$serialPort->open("/dev/ttyACM0");

while ($data = $serialPort->read()) {

    $serialPort->write("TEMP\n");
             
    if($data == "READY"){
    $data = "";   
    }
    if($data != ""){
    $temp = $data;
    
    break;
    }
}
$serialPort->close();

$serialPort->open("/dev/ttyACM0");

while ($data = $serialPort->read()) {

    $serialPort->write("HUMI\n");
             
    if($data == "READY"){
    $data = "";   
    }
    if($data != ""){
    $humi = $data;
    
    break;
    }
}
$serialPort->close();
$serialPort->open("/dev/ttyACM0");

while ($data = $serialPort->read()) {

    $serialPort->write("LIGHT\n");
             
    if($data == "READY"){
    $data = "";   
    }
    if($data != ""){
    $light = $data;
    
    break;
    }
}
$serialPort->close();
$serialPort->open("/dev/ttyACM0");

while ($data = $serialPort->read()) {

    $serialPort->write("PRESS\n");
             
    if($data == "READY"){
    $data = "";   
    }
    if($data != ""){
    $press = $data;
    
    break;
    }
}
$serialPort->close();


  ?>