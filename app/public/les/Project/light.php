<?php
session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}

$datalogin = $_SESSION['user'];
$date1 = isset($_POST['date1']) ? $_POST['date1'] : '';
$date2 = isset($_POST['date2']) ? $_POST['date2'] : '';
$time1 = isset($_POST['time1']) ? $_POST['time1'] : '';
$time2 = isset($_POST['time2']) ? $_POST['time2'] : '';

require_once 'includes/config.php';
require_once 'includes/functions.php';

$sendDate1 = $date1 . " " . $time1;
$sendDate2 = $date2 . " " . $time2;

$db = getDatabase(); 
$stmt = $db->prepare('SELECT * FROM weermetingen');
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$formErrors = array();
$light = array();
$dates2 = array();
 
if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'submit')) {
  $check = true;
  if ($sendDate1 > $sendDate2) {
    $formErrors[] = "The 1st date can't be greater than the 2nd date.";
    $check = false;
  }

  $stmt = $db-> prepare('SELECT COUNT(*) FROM weermetingen WHERE added_on between ? and ?;');
  $stmt->execute([$sendDate1,$sendDate2]);
  $checkIfExits = $stmt->fetch(PDO::FETCH_ASSOC);  

  if ($checkIfExits["COUNT(*)"] == '0') {
    $formErrors[] = "There are no mesurements between the 2 dates, please select a greater range.";
    $check = false;
  }
  if ($check) {
   $stmt = $db->prepare('SELECT * FROM `weermetingen` WHERE added_on between ? and ?');
   $stmt->execute([$sendDate1,$sendDate2]);
   $dataChart = $stmt->fetchAll(PDO::FETCH_ASSOC);
   $light = array();
   $dates2 = array();
   foreach ($dataChart as $licht) {
    $light[] = $licht['licht'];
  }
  foreach ($dataChart as $date) {
    $dates2[] = $date['added_on'];
  }

}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Light</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="stylesheet" type="text/css" href="css/temperatuur.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/aa9a352006.js" crossorigin="anonymous"></script>

</head>
<body>
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
              <a class="nav-link" href="dashboard.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="temperatuur.php">
                <i class="fas fa-temperature-high"></i> Temperature</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="humidity.php">
                <i class="fas fa-tint"></i> Humidity</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="light.php">
                <i class="fas fa-sun"></i> Light</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pressure.php">
                <i class="fas fa-compress-arrows-alt"></i> Pressure</a>
            </li>
        </ul>
        <?php
        if ($datalogin['type'] === 'admin') { ?>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Manage</span>
          </h6>
          <ul class="nav flex-column mb-2">
           <li class="nav-item">
            <a class="nav-link" href="users.php">
                <i class="fas fa-users-cog"></i> Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="messages.php">
                    <i class="fas fa-envelope"></i> Messages</a>
                </li>
            </ul> 
        <?php } ?>
    </div>
  </nav>
              <div class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h1 class="h2">Choose date </h1>
                <?php if (count($formErrors) != 0) {?>
                  <div class="col-sm-9">
                    <div class="alert alert-danger">
                      <strong>Something went wrong.</strong>
                      <br><br>
                      <ul>
                        <?php
                        foreach ($formErrors as $error) {?>
                          <li> <?php echo htmlentities($error);  ?> </li>
                        <?php } ?>
                        
                      </ul>
                    </div>
                  </div>
                <?php } ?>
                <form action="" method="POST" class="form-horizontal">
                  <div class="form-group">
                    <label for="startDate" class="col-sm-3 control-label">Starting date</label>
                    <div class="row">
                      <div class="col-sm-4">
                       <input class="form-control" id="date" name="date1" date-format="YYYY/MM/DD" type="date" required>
                     </div>
                     <div class="col-sm-1"></div>
                     <div class="col-sm-4">
                      <input class="form-control" id="time" name="time1" type="time" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="endDate" class="col-sm-3 control-label">Ending date</label>
                  <div class="row">
                    <div class="col-sm-4">
                     <input class="form-control" id="date" name="date2" date-format="YYYY/MM/DD" type="date" required>
                   </div>
                   <div class="col-sm-1"></div>
                   <div class="col-sm-4">
                    <input class="form-control" id="time" name="time2" type="time" required>
                  </div>
                </div>
              </div>
              <input type="hidden" name="moduleAction" value="submit">
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                  <button type="submit" class="btn btn-primary">Start
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="row">

            <div class="col-md-9 ml-sm-auto col-lg-10 px-4">
              <div class="col-sm-9">
                <canvas id="myChart"></canvas>
              </div>
            </div>
          </div>
          <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
          <script>
            var light =  <?php echo json_encode($light); ?>;
            var datum = <?php echo json_encode($dates2); ?>;
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
      labels: datum,
      datasets: [{
        label: 'Light',
        borderColor: 'rgb(255, 255, 0)',
        data: light
      }]
    },

    // Configuration options go here
    options: {}
  });
</script>
<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">© 2020 Weerstation &mdash; Joran Anseau
</div>
</body>
</html>