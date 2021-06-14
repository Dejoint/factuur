<?php 

require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase();
$stmt = $db-> prepare('SELECT COUNT(*) FROM user;');
$stmt->execute();
 $checkIfExits = $stmt->fetch(PDO::FETCH_ASSOC);  

if ($checkIfExits["COUNT(*)"] !== '0') {
    header('Location: login.php');
    exit();
  }
  
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$repeatPassword = isset($_POST['repeatPassword']) ? $_POST['repeatPassword'] : '';
$passencryp = password_hash($password, PASSWORD_DEFAULT);
$formErrors = array();

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
    if (trim($password) !== trim($repeatPassword)) {
    	$formErrors[] = "The passwords doesn't match.";
        $check = false;
    }
    if ($check) {
    	$stmt = $db-> prepare('INSERT INTO user (`username`, password, type) VALUES (?,?,?)');
    	$stmt->execute(array($username, $passencryp, 'admin'));
    	header('Location: login.php');
    	exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Initial</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
    crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/aa9a352006.js" crossorigin="anonymous"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">
    <link rel="stylesheet" href="css/initial.css">

</head>
<body class="text-center">
    
    <form class="form-signin" method="POST" action="">
        <?php if (count($formErrors) != 0) {?>
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
            <?php } ?>
        <img class="mb-4" src="img/weather.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Welkom bij Weerstation, <br> Maak hier een account aan.</h1>
        
		<label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="username"id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password"id="inputPassword" class="form-control" placeholder="Password" required="" autofocus="">
        <label for="repeatPassword" class="sr-only">Repeat Password</label>
        <input type="password" name="repeatPassword" id="repeatPassword" class="form-control" placeholder="Repeat password" required="">

        <input type="hidden" name="moduleAction" value="login" />

        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">© 2020</p>
        
    </form>
</body>
</html>
