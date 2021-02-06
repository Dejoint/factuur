<?php
session_start();

if (!isset($_SESSION['user'])) {
	header('Location: login.php');
}

require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase(); 

$formErrors = array();

$stmt = $db->prepare('SELECT * FROM klanten;');
$stmt->execute();
$klanten = $stmt->fetchAll(PDO::FETCH_ASSOC);

$newCust = isset($_POST['newCust']) ? $_POST['newCust'] : '';
$newBTW = isset($_POST['newBTW']) ? $_POST['newBTW'] : ' ';
$newAdres = isset($_POST['newAdres']) ? $_POST['newAdres'] : '';
$newGem = isset($_POST['newGem']) ? $_POST['newGem'] : '';
$newPost = isset($_POST['newPost']) ? $_POST['newPost'] : '';
$newMail = isset($_POST['newMail']) ? $_POST['newMail'] : '';

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'submit')) {

	$stmt = $db-> prepare('SELECT COUNT(*) FROM klanten WHERE name = ?;');
	$stmt->execute([$newCust]);
	$checkIfExits = $stmt->fetch(PDO::FETCH_ASSOC);

	if (trim($newCust) === '') {
		$formErrors[] = 'Gelieve een klantnaam in te geven.';
	};
	
	
	if ($checkIfExits["COUNT(*)"] != '0') {
		$formErrors[] = 'Er bestaat al een klant met deze naam';
	}
	if (count($formErrors) == 0) {
		$stmt = $db-> prepare('INSERT INTO klanten (name, mail, btwnr, adres, gemeente, postcode) VALUES (?,?,?,?,?,?)');
		$stmt->execute(array($newCust, $newMail, $newBTW, $newAdres, $newGem, $newPost));
		header('Location: klanten.php');
	};

};

?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="UTF-8">
	<title>Home</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/aa9a352006.js" crossorigin="anonymous"></script>
	

</head>
<body>
	<?php require_once('header.php') ?>
	
	<div class="container">
		
		<h1 class="h2">Klant toevoegen</h1>
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
				<form action="" method="POST" class="form-horizontal">
					<div class="form-group">
						<label for="newCust" class="col-sm-3 control-label">Naam</label>
						<div class="col-sm-9">
							<input type="text" name="newCust" id="newCust" class="form-control" value="" placeholder="Naam" required>
						</div>
					</div>
					<div class="form-group">
						<label for="newPrice" class="col-sm-3 control-label">E-mail</label>
						<div class="col-sm-9">
							<input type="email" name="newMail" id="newMail" class="form-control" value="" placeholder="E-mail" required>
						</div>
					</div>
					<div class="form-group">
						<label for="newAdres" class="col-sm-3 control-label">Adres</label>
						<div class="col-sm-9">
							<input type="text" name="newAdres" id="newAdres" class="form-control" value="" placeholder="Adres" required>
						</div>
					</div>
					<div class="form-group">
						<label for="newGem" class="col-sm-3 control-label">Gemeente</label>
						<div class="col-sm-9">
							<input type="city" name="newGem" id="newGem" class="form-control" value="" placeholder="Gemeente" required>
						</div>
					</div>
					<div class="form-group">
						<label for="newPost" class="col-sm-3 control-label">Postcode</label>
						<div class="col-sm-9">
							<input type="zip" name="newPost" id="newPost" class="form-control" value="" placeholder="Postcode" required>
						</div>
					</div>
					<div class="form-group">
						<label for="newBTW" class="col-sm-3 control-label">BTW-nummer</label>
						<div class="col-sm-9">
							<input type="text" name="newBTW" id="newBTW" class="form-control" value="" placeholder="BTW-nummer">
						</div>
					</div>
					
								

								<input type="hidden" name="moduleAction" value="submit">
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-6">
										<button type="submit" class="btn btn-default">
											<i class="fa fa-btn fa-plus"></i> Voeg klant toe
										</button>
									</div>
								</div>
							</form>

						</div>
					</div>
					<h1 class="h2">Klanten</h1>
					<div class="col-md ">
						<div class="table-responsive">
							<table class="table table-striped table-sm">
								<thead>
									<tr>

										<th>Naam</th>
										<th>E-mail</th>
										<th>Adres</th>
										<th>Gemeente</th>
										<th>Postcode</th>
										<th>BTW-nummer</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php

									foreach ($klanten as $klant) {

										?>
										<tr>

											<td><?php echo htmlentities($klant['name'])?></td>
											<td><?php echo htmlentities($klant['mail'])?></td>
											<td><?php echo htmlentities($klant['adres'])?></td>
											<td><?php echo htmlentities($klant['gemeente'])?></td>
											<td><?php echo htmlentities($klant['postcode'])?></td>
											<td><?php echo htmlentities($klant['btwnr'])?></td>
											<td>
												<a class="btn btn-primary" href="edit.php?id=<?php echo htmlentities($artikel['id'])?>" role="button">
													<i class="fa fa-btn fa-pencil"></i> Wijzigen
												</a>
											</td>
											<td>

												<a class="btn btn-danger" href="delete.php?id=<?php echo htmlentities($artikel['id'])?>" role="button">
													<i class="fa fa-btn fa-trash"></i> Verwijderen
												</a>



											</td>

										<?php }
										?>



									</tbody>
								</table>
							</div>
						</body>
						</html>