<?php
session_start();

if (isset($_SESSION['user'])) {
  $userinfo = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/footer.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
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
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
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
      <a class="navbar-brand"> Welkom, <?php echo htmlentities($userinfo["username"]); ?> </a>
      <a href="logout.php" type="button" class="btn btn-outline-light" ><i class="fas fa-user"></i> Logout</a>
    <?php }
    else {?>
      <a href="login.php" type="button" class="btn btn-outline-light"><i class="fas fa-user"></i> Login</a>
    <?php } ?>
  </div>
</nav>
<div class="top-image">
  <div class="top-text">
    <h1>Home</h1>
  </div>
</div>
<div class="container">
<div class="row justify-content-md-center">
  
   
   <div class="col">
    
    <div class="card" style="">
      <div class="card-body">
        <h5 class="card-title">Mogelijkheden</h5>
        <p class="card-text">Via weerstation is het mogelijk om verschillende weerselementen te meten via Arduino: <ul>
          <li>Temperatuur</li>
          <li>Vochtigheid</li>
          <li>Lichtsterkte</li>
          <li>Luchtdruk</li>
        </ul></p>
        <a href="login.php" class="btn btn-primary">Begin!</a>
      </div>
    </div>
  </div>
    <div class="col">
      <img src="/img/arduino.png" class="img-fluid" alt="...">
    </div>
  
 </div> 
 <div class="row justify-content-end">
  <div class="col">
    <img src="/img/example.png" class="img-fluid">
  </div>
<div class="col">
  <div class="card" style="">
      <div class="card-body">
        <h5 class="card-title">Grafieken</h5>
        <p class="card-text">Via weerstation is het mogelijk om de grafieken van verschillende weerselementen te bekijken:<ul>
          <li>Temperatuur</li>
          <li>Vochtigheid</li>
          <li>Lichtsterkte</li>
          <li>Luchtdruk</li>
        </ul></p>
        
      </div>
    </div>
</div>
</div>
</div>
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
</body>
</html>