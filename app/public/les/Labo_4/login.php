<?php 
session_start();

if (isset($_SESSION['user'])) {
    header('Location: index.php');
}
require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase();

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$passencryp = password_hash($password, PASSWORD_DEFAULT);
$formErrors = array();

$login = (string) isset($_COOKIE['login']) ? $_COOKIE['login']:'';

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'login')) {
    $check = true;
    if (trim($username) === '') {
        $formErrors[] = "Please enter username.";
        $check = false;
    }
    if (trim($password) === '') {
        $formErrors[] = "Please enter password";
        $check = false;
    }
    if (count($formErrors) != 0) {
        $check = false;
    }
    $stmt = $db->query('SELECT passw FROM users WHERE name = "' . $name .'"' );
    $pass = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($username, $passencryp) && $check) {
        $_SESSION['user'] = array( 'username' => $username, 'id' => 25, 'email' => $username . '@student.odisee.be');
        setcookie('login', $check, time() + 60*60*24*7);
        header('Location: index.php');
        exit();
    }
    else {
        $check = false;
        $formErrors[] = 'Username does not match password';
    }
    
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mijn takenlijst</title>
    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/tasks.css" rel="stylesheet">
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header"><!-- Just an image -->
                <a class="navbar-brand" href="index.php"><img src="img/ikdoeict.png" height="20" alt="ikdoeict alt logo"></a>
                <a class="navbar-brand" href="index.php">Mijn takenlijst</a>
            </div>
            <!-- Weer te geven indien ingelogd -->
            <form class="navbar-form navbar-right" method="post" action="logout.php">
                <button type="submit" class="btn btn-default">Uitloggen</button>
            </form>
            <!-- Weer te geven indien niet ingelogd -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="login.php">Inloggen</a></li>
            </ul>
        </div>

    </nav>

    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Inloggen
                </div>
                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    <!-- Form Error List -->
                    <?php  
                    
                    if (count($formErrors) != 0) {?>

                        <!-- Display Validation Errors -->
                        <!-- Form Error List -->
                        <div class="alert alert-danger">
                            <strong>Hier is iets misgegaan.</strong>
                            <br><br>
                            <ul>
                                <?php
                                foreach ($formErrors as $error) {?>
                                    <li> <?php echo $error;  ?> </li>
                                <?php } ?>

                            </ul>
                        </div>
                    <?php }?>
                    <!-- Task Edit Form -->
                    <form action="" method="POST" class="form-horizontal">

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="username" class="col-sm-3 control-label">Gebruikernaam</label>

                            <div class="col-sm-9">
                                <input type="text" name="username" id="username" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">Paswoord</label>

                            <div class="col-sm-9">
                                <input type="password" name="password" id="password" class="form-control" value="">
                            </div>
                        </div>

                        <input type="hidden" name="moduleAction" value="login" />

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    Inloggen
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php if (!isset($_COOKIE['login'])) { ?>
                        <p class="text-left">Er werd op dit toestel nog niet ingelogd op deze website.</p>
                    <?php } ?>
                    
                </div>
            </div>

        </div>
    </div>
    <footer class="footer mt-auto py-3">
        <div class="container">
            <span class="text-muted">&copy; 2019 Odisee &mdash; Opleiding Elektronica-ICT &mdash; Server-side Web Scripting</span>
        </div>
    </footer>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>