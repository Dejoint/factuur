<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
$datalogin = $_SESSION['user'];

$temp = 15.4;
$press = 1000;
$light = 75;
$humi = 20;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/aa9a352006.js" crossorigin="anonymous"></script>
    <script src="/js/dashboard.js"></script>
    <script type="text/javascript" src="/js/gauge.js"></script>
    <script type="text/javascript" src="/js/highlight.pack.js"> </script>
    <script>hljs.initHighlightingOnLoad();</script>

</head>
<body>
  <div id="dom-temp" style="display: none;">
    <?php echo htmlspecialchars($temp);?>
  </div>
  <div id="dom-press" style="display: none;">
    <?php echo htmlspecialchars($press);?>
  </div>
  <div id="dom-light" style="display: none;">
    <?php echo htmlspecialchars($light);?>
  </div>
  <div id="dom-humi" style="display: none;">
    <?php echo htmlspecialchars($humi);?>
  </div>

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Weerstation</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <div class="navbar-nav mr-auto"></div>
        
        <a type="button" class="btn btn-outline-light" href="logout.php"><i class="fas fa-user"></i> Logout</a>

    </div>

</nav>
  <nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="dashboard.php">
            <i class="fas fa-tachometer-alt"></i> Dashboard 
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="temperatuur.php">
            <i class="fas fa-temperature-high"></i> Temperature 
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="humidity.php">
            <i class="fas fa-tint"></i> Humidity
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="light.php">
            <i class="fas fa-sun"></i> Light
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pressure.php"> 
            <i class="fas fa-compress-arrows-alt"></i> Pressure
          </a>
        </li>

      </ul>
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Manage</span>

      </h6>
      <ul class="nav flex-column mb-2">
        <li class="nav-item">
          <a class="nav-link" href="users.php">
            <i class="fas fa-users-cog"></i> Users
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="messages.php">
            <i class="fas fa-envelope"></i> Messages
          </a>
        </li>
      </ul> 
    </div>
  </nav>

<div class="row">
    <div class="col-1"></div>
    <div class="col">

        <h1 class="text-center">Temperatuur</h1>
        <div class="display">
        	<div id="gauge1" class="gauge-container two"></div>
      	</div>
    </div>
    <div class="col">
        <h1 class="text-center">Druk</h1>
        <div class="display">
        	<div id="gauge2" class="gauge-container two"></div>
      	</div>
    </div>
</div>
<div class="row">
    <div class="col-1"></div>
    <div class="col">
    	<h1 class="text-center">Lichtsterkte</h1>
    	<div class="display">
        	<div id="gauge3" class="gauge-container two"></div>
      	</div>
    </div>
    <div class="col">
    	<h1 class="text-center">Vochtigheid</h1>
    	<div class="display">
        	<div id="gauge4" class="gauge-container two"></div>
      	</div>
    </div>
    </div>


<script type="text/javascript" src="../src/gauge.js"> </script>
<script>

  var pad = function(tar) {}
  var gauge1 = Gauge(
    document.getElementById("gauge1"),
    {
      min: -50,
      max: 50,
      dialStartAngle: 180,
      dialEndAngle: 0,
      value: 15,
      viewBox: "0 0 100 57",
      color: function(value) {
        if(value < 0) {
          return "#1a60c9";
        }else if(value < 22){
          return "#5ee432";
        }else if(value < 40) {
          return "#e48832";
        }else {
          return "#ef4655";
        }
      }
    }
    );
var gauge2 = Gauge(
    document.getElementById("gauge2"),
    {
      min: 950,
      max: 1050,
      dialStartAngle: 180,
      dialEndAngle: 0,
      value: 1013,
      viewBox: "0 0 100 57",
      color: function(value) {
        if(value < 1000) {
          return "#5ee432";
        }else if(value < 1020) {
          return "#fffa50";
        }else if(value < 1030) {
          return "#f7aa38";
        }else {
          return "#ef4655";
        }
      }
    }
    );
var gauge3 = Gauge(
    document.getElementById("gauge3"),
    {
      min: 0,
      max: 100,
      dialStartAngle: 180,
      dialEndAngle: 0,
      value: 50,
      viewBox: "0 0 100 57",
      color: function(value) {
        if(value < 20) {
          return "#5ee432";
        }else if(value < 40) {
          return "#fffa50";
        }else if(value < 60) {
          return "#f7aa38";
        }else {
          return "#ef4655";
        }
      }
    }
    );
var gauge4 = Gauge(
    document.getElementById("gauge4"),
    {
      min: 0,
      max: 100,
      dialStartAngle: 180,
      dialEndAngle: 0,
      value: 50,
      viewBox: "0 0 100 57",
      color: function(value) {
        if(value < 30) {
          return "#5ee432";
        }else if(value < 60) {
          return "#fffa50";
        }else {
          return "#1a60c9";
        }
      }
    }
    );/*
  (function loop() {
    var value1 = Math.random() * 100;
    gauge1.setValueAnimated(Math.random() * (50+50+1)-50 , 3);
    gauge2.setValueAnimated(value1 + 950, 3);
    gauge3.setValueAnimated(value1, 3);
    gauge4.setValueAnimated(value1, 3);
    window.setTimeout(loop, 4000);
  })();
  */
  var temp = document.getElementById("dom-temp");
  var press = document.getElementById("dom-press");
  var light = document.getElementById("dom-light");
  var humi = document.getElementById("dom-humi");
  gauge1.setValueAnimated(temp.textContent);
  gauge2.setValueAnimated(press.textContent);
  gauge3.setValueAnimated(light.textContent);
  gauge4.setValueAnimated(humi.textContent);

</script>

</body>
</html>