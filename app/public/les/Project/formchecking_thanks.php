<?php
session_start();

if (isset($_SESSION['user'])) {
	$userinfo = $_SESSION['user'];
}
$fname = isset($_GET['fname']) ? $_GET['fname'] : false;

?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<title>Contact</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/contact.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

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
				<li class="nav-item">
					<a class="nav-link" href="#">About</a>
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
				<a class="navbar-brand"> Welkom, <?php echo htmlentities($userinfo["username"]); ?> </a>
				<a href="logout.php" type="button" class="btn btn-outline-light" ><i class="fas fa-user"></i> Logout</a>
			<?php }
			else {?>
				<a href="login.php" type="button" class="btn btn-outline-light"><i class="fas fa-user"></i> Login</a>
			<?php } ?>
		</div>
	</nav>
	<section id="parallax-one">
		<div class="top-image">
			<div class="top-text">
				<h1 style="font-size: 500%">Contact</h1>
				<section id="scroll">
					<a href="#contact"><span></span></a>
				</div>
			</div>
		</section>
		<section id="contact">
			<div id="contactsec">

				<div class="container">
					<div class="row">
						<div class="col"> 
							<div class="alert alert-success" role="alert">
								<?php echo '<h4 class="alert-heading"> Bedankt '  . htmlentities($fname).  '!</h4>'?>
								<p>Je info werd correct doorgegeven we gaan u zo snel mogelijk antwoorden.</p>
							</div>
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