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
	<title>Users</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="css/dashboard.css">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/aa9a352006.js" crossorigin="anonymous"></script>

</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
              <a class="nav-link" href="light.php">
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
	<div class="row align-items-center">
	<div class="col-md"></div>
		<div class="alert alert-danger" role="alert">
  Error, this page does not exist or you are not authorized to view this page! — Return to dashboard!
</div>
	<div class="col-md"></div>
</div>
</body>
</html>