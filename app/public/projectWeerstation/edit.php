<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
$datalogin = $_SESSION['user'];

if ($datalogin['type'] !== 'admin') {
    header('Location: error.php');
}

require_once 'includes/config.php';
require_once 'includes/functions.php';


$db = getDatabase();



$types = array('admin','normal'); 
$formErrors = array(); 

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0; 
if ($id == 0) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
};

$changeUsername = isset($_POST['username']) ? $_POST['username'] : ''; 
$changeType = isset($_POST['type']) ? $_POST['type'] : 'normal'; 

$stmt = $db->prepare('SELECT * FROM  user WHERE id = ?' );
$stmt->execute([$id]);
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userInfo) {
    header('Location: error.php');
    exit();
}

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'edit')) {
    $stmt = $db->prepare('UPDATE user SET username =?, type =? WHERE id =?');
    $stmt->execute([$changeUsername,$changeType, $id]);
    header('Location: users.php');
    exit();
}

?><!DOCTYPE html>
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
              <a class="nav-link" href="#">
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
            <a class="nav-link active" href="users.php">
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
    <h1 class="h2">Change user</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">
        <div class="form-group">
            <label for="username" class="col-sm-3 control-label">Username</label>
            <div class="col-sm-9">
                <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlentities($userInfo['username'])?>">
            </div>
        </div>
        <div class="form-group">
            <label for="type" class="col-sm-3 control-label">Type</label>
            <div class="col-sm-9">
                <select name="type" id="type" class="form-control">
                    <?php
                    foreach ($types as $type) {?>
                        <option value="<?php echo htmlentities($type)?>" > <?php echo $type ?></option>

                    <?php  } ?>
                </select>
            </div>
        </div>
        <input type="hidden" name="moduleAction" value="edit" />
        <input type="hidden" name="id" value="<?php echo htmlentities($id)?>" />
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-pencil"></i> Edit user
                </button>
            </div>
        </div>
    </form>
    <p class="text-left"><a href="users.php">Annuleren en terug naar overzicht</a></p>
</div>
</div>
</div>

<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">&copy; 2021 Weerstation &mdash; Joran Anseau</span>
    </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>