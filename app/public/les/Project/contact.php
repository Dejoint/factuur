<?php
session_start();

if (isset($_SESSION['user'])) {
    $userinfo = $_SESSION['user'];
}


require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase();

$fname = isset($_POST['fname']) ? (string) $_POST['fname'] : '';
$lname = isset($_POST['lname']) ? (string) $_POST['lname'] : '';
$email = isset($_POST['email']) ? (string) $_POST['email'] : '';
$message = isset($_POST['message']) ? (string) $_POST['message'] : '';


if (isset($_POST['btnSubmit'])) {
    $stmt = $db->prepare('INSERT INTO messages (fname, lname, email, message) VALUES (\''. $fname .  '\',\'' . $lname .'\',\'' . $email .'\',\'' . $message . '\')');
    $stmt->execute(array(htmlentities($fname), htmlentities($lname), htmlentities($email), htmlentities($message)));
    if ($db->lastInsertId() !== 0) {
      header('Location: formchecking_thanks.php?fname=' . urlencode($fname));
      exit();
    }
    else {
      echo 'Databankfout.';
      exit;
    }   

  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="css/footer.css">
      <link rel="stylesheet" type="text/css" href="css/contact.css">
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
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="contact.php">Contact <span class="sr-only">(current)</span></a>
            </li>
            <?php
            if (isset($_SESSION['user'])) { ?>
            <li class="nav-item">
            	<a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
        <?php } ?>
        </ul>
        <?php 
       if (isset($_SESSION['user'])) {
       	?> 
       	<a class="navbar-brand"> Welkom, <?php echo $userinfo["username"]; ?> </a>
       	<a href="logout.php" type="button" class="btn btn-outline-light" ><i class="fas fa-user"></i> Logout</a>
		<?php }
		else {?>
        <a href="login.php" type="button" class="btn btn-outline-light"><i class="fas fa-user"></i> Login</a>
    <?php } ?>
    </div>
</nav>
<div class="top-image"></div>
        <div class="container">
          <div class="row">
            <div class="col"> 
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <form class="needs-validation" novalidate>
                  <label for="fname">Voornaam</label>
                  <input type="text" name="fname" class="form-control" id="fname" placeholder="Voornaam"  required>

                  <label for="lname">Achternaam</label>
                  <input type="text" name="lname" class="form-control" id="lname" placeholder="Achternaam"  required>

                  <label for="email">E-mail</label>
                  <input type="email" class="form-control"  name="email" id="email" placeholder="E-mail" required>         

                  <label for="subject">Onderwerp</label>
                  <textarea type="text" id="message" name="message" placeholder="Typ uw bericht" required></textarea>

                  <input type="submit" id="btnSubmit" name="btnSubmit" value="Verstuur"/>
                </form>
              </form>
            </div> 
            <div class="col">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2507.61214869716!2d3.707725915979003!3d51.06024897956406!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c37113c8d9fd6b%3A0xdd513b9ceba13bb6!2sOdisee%20Technologiecampus%20Gent!5e0!3m2!1snl!2sbe!4v1607332586048!5m2!1snl!2sbe"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>            
              <div id="rcorners">
                <div class="contactinfo">
                  <p>Joran Anseau</p>         
                  <p><a href="tel:+32490438364">+32490438364</a></p>
                  <p><a href="mailto:joran.anseau@student.odisee.be">joran.anseau@student.odisee.be</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="footer">
      <div class="container">
        <div class="row justify-content-md-center">
          <div class="col-xs-2 col-sm-2 col-md-2">
            <h5>Quick links</h5>
            <ul class="list-unstyled quick-links">
              <li><a href="index.php"><i class="fa fa-angle-double-right"></i>Home</a></li>
              <?php if (isset($_SESSION['user'])) { ?>
                <li><a href="dashboard.php"><i class="fa fa-angle-double-right"></i>Dashboard</a></li>
              <?php } ?>
              <li><a href="contact.php"><i class="fa fa-angle-double-right"></i>Contact</a></li>
              <li><a href="about.html"><i class="fa fa-angle-double-right"></i>About</a></li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
            <ul class="list-unstyled list-inline social text-center">
              <li class="list-inline-item"><a href="https://www.facebook.com/joran.anseau"><i class="fa fa-facebook"></i></a></li>
              <li class="list-inline-item"><a href="https://wa.me/32490438364"><i class="fa fa-whatsapp"></i></a></li>
              <li class="list-inline-item"><a href="https://www.linkedin.com/in/joran-anseau-b12676154/"><i class="fa fa-linkedin"></i></a></li>
              <li class="list-inline-item"><a href="https://www.instagram.com/jorananseau/?hl=nl"><i class="fa fa-instagram"></i></a></li>

              <li class="list-inline-item"><a href="mailto:joran.anseau@student.odisee.be"><i class="fa fa-envelope"></i></a></li>
            </ul>
          </div>
        </hr>
      </div>  
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
          <p class="h6">&copy All rights Reversed.<a class="text-green ml-2" href="https://www.jorananseau.ikdoeict.be" target="_blank">Joran Anseau</a></p>
        </div>
      </hr>
    </div>
</div>
</section>
</body>
</html>