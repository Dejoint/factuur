<?php
session_start();

if (!isset($_SESSION['user'])) {
	header('Location: login.php');
}

require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase(); 

$total = 0;

function getData($id){
	$db = getDatabase(); 
	$stmt = $db->prepare('SELECT * FROM verkoop WHERE id = ?');
	$stmt->execute(array($id));
	return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

$id = isset($_POST['id']) ? $_POST['id'] : '';
$moduleAction = isset($_POST['moduleAction']) ? $_POST['moduleAction'] : '';

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'emptyCart')) {
	unset($_SESSION['cart']);
}
if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'delete')) {
	foreach ($_SESSION['cart'] as $key => $array) {	
		if ((int)$array[1] == $id) {
			unset($_SESSION['cart'][$key]);
		}
	}
}


?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="UTF-8">
	<title>Facturatie</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/aa9a352006.js" crossorigin="anonymous"></script>
</head>
<body>
	<?php require_once('header.php') ?>
		<div class="container-fluid">
			<h2>Factuur</h2>
				<hr>
			<div class="row">
				<div class="col-md-6">
					<h3>Gegevens</h3>
					<hr>
					<form action="pdf.php" method="POST" class="form-horizontal">
						<div class="form-group">
							<label for="newCust" class="col-sm-3 control-label">Naam <span class="error" style="color: red" >*</span></label>
							<div class="col-sm-9">
								<input type="text" name="cust" id="cust" class="form-control" value="" placeholder="Naam" required>
							</div>
						</div>
						<div class="form-group">
							<label for="newPrice" class="col-sm-3 control-label">E-mail</label>
							<div class="col-sm-9">
								<input type="email" name="mail" id="mail" class="form-control" value="" placeholder="E-mail">
							</div>
						</div>
						<div class="form-group">
							<label for="newAdres" class="col-sm-3 control-label">Adres</label>
							<div class="col-sm-9">
								<input type="text" name="adres" id="adres" class="form-control" value="" placeholder="Adres" >
							</div>
						</div>
						<div class="form-group">
							<label for="newGem" class="col-sm-3 control-label">Gemeente</label>
							<div class="col-sm-9">
								<input type="city" name="gem" id="gem" class="form-control" value="" placeholder="Gemeente">
							</div>
						</div>
						<div class="form-group">
							<label for="newPost" class="col-sm-3 control-label">Postcode</label>
							<div class="col-sm-9">
								<input type="zip" name="post" id="post" class="form-control" value="" placeholder="Postcode">
							</div>
						</div>
						<div class="form-group">
							<label for="newBTW" class="col-sm-3 control-label">BTW-nummer</label>
							<div class="col-sm-9">
								<input type="text" name="BTW" id="BTW" class="form-control" value="" placeholder="BTW-nummer">
							</div>
						</div>
						<div class="form-group">
							<label for="newBTW" class="col-sm-3 control-label">Factuurnummer <span class="error" style="color: red" >*</span></label>
							<div class="col-sm-9">
								<input type="text" name="factnum" id="factnum" class="form-control" value="" placeholder="Factuurnummer" required>
							</div>
						</div>
						<div class="form-group">
							<label for="newBTW" class="col-sm-3 control-label">Betreft <span class="error" style="color: red" >*</span></label>
							
							<div class="col-sm-9">
								<input type="text" name="betreft" id="betreft" class="form-control" value="" placeholder="Betreft" required>
							</div>
						</div>
						<input type="hidden" name="moduleAction" value="submit">
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-success">
									<i class="fas fa-file-pdf"></i> Maak factuur
								</button>
							</div>
						</div>
					</form>
			</div>
			<div class="col-md-6">
				<h3>Artikels</h3>
				<hr>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					<input type="hidden" name="moduleAction" value="emptyCart" />
					<button type="submit"  class="btn btn-danger btn-md btn-block"><i class="fa fa-btn fa-trash"></i> Lijst leegmaken</button>
				</form>
				<table class="table table-striped table-sm">
					<thead>
						<tr>
							<th>#</th>
							<th>Naam</th>
							<th>Categorie</th>
							<th>Eenheidsprijs</th>
							<th>Aantal</th>
							<th>Regeltotaal</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (isset($_SESSION['cart'])) {
							$array = $_SESSION['cart'];
							$total = 0;
							$totAantal = 0;
							$count = 1;
							foreach ($array as $subArray) {
								$artikelInfo = getData($subArray[1]);

								$regelTotaal = (double)$subArray[0] * (double)$artikelInfo[0]['prijs'];
								$totAantal = $totAantal + $subArray[0];
								$total = (double)$total + (double)$regelTotaal;
								$idArt = $subArray[1]
								?>

								<tr>
									<td><?php echo $count ?></td>
									<td><?php echo $artikelInfo[0]['naam']?></td>
									<td><?php echo $artikelInfo[0]['categorie']?></td>
									<td>€<?php echo $artikelInfo[0]['prijs']?></td>
									<td><?php echo $subArray[0] ?></td>
									<td>€<?php echo $regelTotaal ?></td>
									<td>
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
											<input type="hidden" name="moduleAction" value="delete" />
											<input type="hidden" name="id" value="<?php echo htmlentities($subArray[1]) ?>" />
											<button type="submit" class="btn btn-danger" id="btn-delete">
												<i class="fas fa-times"></i>
											</button>
										</form>
									</td>
								</tr>
								<?php $count++; }
							} ?>
						</tbody>
					</table>

				
				
					<div class="col-md-4">
						<h6>FACTUUR DETAILS</h6>
						<hr>
						<?php
						if (isset($_SESSION['cart'])){
							$count  = count($_SESSION['cart']);
							echo "<h6>Aantal ($totAantal stuks)</h6>";
						}else{
							echo "<h6>Aantal (0 stuks)</h6>";
						}
						?>
					</div>
					<div class="col-md-4">
						<hr>
						<h6><?php
						echo 'Totaal te betalen: €' . number_format($total, 2);
						?></h6>
					</div>
			</div>

			</div>
		</div>
	</body>
</html>