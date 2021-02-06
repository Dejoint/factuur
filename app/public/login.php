<?php
session_start();
error_reporting(0);

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}

require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase();

$username = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$passencryp = password_hash($password, PASSWORD_DEFAULT);
$formErrors = array();

$stmt = $db-> prepare('SELECT COUNT(*) FROM user');
$stmt->execute();
$count = $stmt->fetch(PDO::FETCH_ASSOC);

if ($count['COUNT(*)'] == 0) {
    header('Location: initial.php');
    exit();
}

$stmt = $db->prepare('SELECT COUNT(*) FROM user WHERE username = ?;');
$stmt->execute([$username]);
$checkIfExits = $stmt->fetch(PDO::FETCH_ASSOC);

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
   
if ($checkIfExits["COUNT(*)"] == '0') {
        
        $check = false;
    }

    $stmt = $db->prepare('SELECT password, Id, type FROM user WHERE username = ?;' );
    $stmt->execute([$username]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($check) {
    if (password_verify($password, $data['password']) and $check) {
        $_SESSION['user'] = array( 'username' => $username, 'id' => $data['Id'], 'type' => $data['type']);
        setcookie('login', $check, time() + 60*60*24*7);
        header('Location: index.php');
        exit();
    }
    else{
      $formErrors[] = 'Username or password is incorrect.';  
    }
}
    
    else{
        $formErrors[] = 'Username or password is incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
    <link rel="stylesheet" href="css/signin.css">

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
        <img class="mb-4" src="img/logo.png" alt="" width="100" height="100">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email"id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="">
        <input type="hidden" name="moduleAction" value="login" />
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">© <?php echo date('Y') ?></p>
        <a href="index.php">Return to startpage</a>
    </form>
</body>
</html>