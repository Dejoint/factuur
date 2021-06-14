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

$newUser = isset($_POST['newUser']) ? $_POST['newUser'] : '';
$newPass = isset($_POST['newPass']) ? $_POST['newPass'] : '';
$passencryp = password_hash($newPass, PASSWORD_DEFAULT);
$newType = isset($_POST['newType']) ? $_POST['newType'] : '';

$stmt = $db-> prepare('SELECT COUNT(*) FROM user WHERE username = ?;');
$stmt->execute([$newUser]);
$checkIfExits = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'submit')) {

    
	if (trim($newUser) === '') {
		$formErrors[] = 'Gelieve een gebruikersnaam in te geven.';
	};
	if (strlen(trim($newPass)) <= 5) {
		$formErrors[] = 'Gelieve een langer wachtwoord te gebruiken';
	}
	if (! in_array($newType, $types)) {
		$formErrors[] = 'Je hebt geprutst met de types.';
	};
	if ($checkIfExits["COUNT(*)"] != '0') {
		$formErrors[] = 'Er bestaat al een gebruiker met deze gebruikersnaam';
	}
	if (count($formErrors) == 0) {
		$stmt = $db-> prepare('INSERT INTO user (username, password, type) VALUES (?,?,?)');
		$stmt->execute(array($newUser, $passencryp, $newType));
		header('Location: users.php');
	};

};

$stmt = $db->prepare('SELECT * FROM  user');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
					<a class="nav-link active" href="users.php">
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
	<div class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<h1 class="h2">Add user</h1>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php if (count($formErrors) != 0) {?>
					<div class="alert alert-danger">
						<strong>Hier is iets misgegaan.</strong>
						<br><br>
						<ul>
							<?php
							foreach ($formErrors as $error) {?>
								<li> <?php echo htmlentities($error);  ?> </li>
							<?php } ?>
							
						</ul>
					</div>
				<?php }?>

				<!-- New Task Form -->
				<form action="" method="POST" class="form-horizontal">

					<!-- Task Name -->
					<div class="form-group">
						<label for="newUser" class="col-sm-3 control-label">Username (email)</label>

						<div class="col-sm-9">
							<input type="email" name="newUser" id="newUser" class="form-control" value="" placeholder="Username" required>
						</div>
					</div>

					<div class="form-group">
						<label for="newPass" class="col-sm-3 control-label">Password</label>

						<div class="col-sm-9">
							<input type="text" name="newPass" id="newPass" class="form-control" value="" placeholder="Password" required>
						</div>
					</div>
					<div class="form-group">
						<label for="newType" class="col-sm-3 control-label">Accounttype</label>
						<div class="col-sm-9">
							<select name="newType" id="newType" class="form-control" required>
								<option value="normal"> Standaard</option>
								<option value="admin"> Administrator</option>
							</select>
						</div>
					</div>
					<input type="hidden" name="moduleAction" value="submit">
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
							<button type="submit" class="btn btn-default">
								<i class="fa fa-btn fa-plus"></i> Voeg gebruiker toe
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<h1 class="h2">Users</h1>
		<div class="col-md-9  ">
			<div class="table-responsive">
				<table class="table table-striped table-sm">
					<thead>
						<tr>
							<th>#</th>
							<th>Username</th>
							<th>Accounttype</th>
							<th>added_on</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 1;
						foreach ($users as $user) {

							?>
							<tr>
								<td><?php echo htmlentities($count)?></td>
								<td><?php echo htmlentities($user['username'])?></td>
								<td><?php echo htmlentities($user['type'])?></td>
								<td><?php echo htmlentities($user['added_on'])?></td>
								<td>
									<a class="btn btn-primary" href="edit.php?id=<?php echo htmlentities($user['Id'])?>" role="button">
										<i class="fa fa-btn fa-pencil"></i> Wijzigen
									</a>
								</td>
								<td>
									<?php if ($datalogin['username'] != $user['username']) {?>
										<a class="btn btn-danger" href="delete.php?id=<?php echo htmlentities($user['Id'])?>" role="button">
											<i class="fa fa-btn fa-trash"></i> Verwijderen
										</a>
									<?php } ?>

									
								</td>

								<?php $count++; }
								?>
								
								
								
							</tbody>
						</table>
					</div>
				</body>
				</html>