<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
if (!isset($_SESSION['user'])) {
header('Location: login.php');
}

require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase(); 

$formErrors = array();

$id = isset($_POST['id']) ? $_POST['id'] : '';
$aantal = isset($_POST['aantal']) ? $_POST['aantal'] : '';
$addId = isset($_POST['addId']) ? $_POST['addId'] : '';
$stmt = $db->prepare('SELECT * FROM verkoop ORDER BY categorie;');
$stmt->execute();
$verkoop = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = 0;
if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'submit')) {
	if (isset($_SESSION['cart'])) {
		$toegevoegd = false;
		$nrArtikel = 0;
		foreach ($_SESSION['cart'] as $key => $artikel) {
			
			if ($addId == $artikel[1]) {
				$artikel[0] = $artikel[0] + $aantal;
				$item_array = array($artikel[0], $addId);
				$_SESSION['cart'][$key] = $item_array;
				$toegevoegd = true;
			}
			$nrArtikel++;
		}
		if (!$toegevoegd) {
			$item_array = array($aantal, $addId);
			$count = max(array_keys($_SESSION['cart']));
			$_SESSION['cart'][$count+1] = $item_array;
		}
	
		}else{
		$item_array = array($aantal, $addId);
		$_SESSION['cart'][0] = $item_array;
	}
}	
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
function getData($id){
$db = getDatabase(); 
$stmt = $db->prepare('SELECT * FROM verkoop WHERE id = ?');
$stmt->execute(array($id));
return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

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

<div class="container-fluid">
	<h1 class="h2">Artikelen</h1>
	<hr>
	<div class="row">
	<div class="col-md-6">
		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th>Naam</th>
						<th>Prijs</th>
						<th>Categorie</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($verkoop as $artikel) {
						?>
						<tr>
							<td><?php echo htmlentities($artikel['naam'])?></td>
							<td><?php echo htmlentities('€' . $artikel['prijs'])?></td>
							<td><?php echo htmlentities($artikel['categorie'])?></td>
                    		<td>
                    			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo htmlentities($artikel['id']) ?>" data-name="<?php echo htmlentities($artikel['naam'])?>"> Add
                        		</button>
                    		</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
<div class="col-md-6">
	<h3>Cart</h3>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<form action="" method="POST" class="form-horizontal">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
  	<div class="form-group">
		<div class="col-sm-9">
			<input type="number" name="aantal" id="aantal" class="form-control" value="" placeholder="Aantal" required>
		</div>
	</div>
  </div>
  <div class="modal-footer">
  	<input  type="hidden" name="addId" id="addId" value="0">
  	<input type="hidden" name="moduleAction" value="submit">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Toevoegen</button>
  </div>
</form>
</div>
</div>
</div>
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var id = button.data('id') // Extract info from data-* attributes
var name = button.data('name')
// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
var modal = $(this)
modal.find('.modal-title').text('Toevoegen: ' + name)
modal.find('.modal-body input').val(name)
document.getElementById("addId").value = id;
console.log(id)
})
</script>
</body>
</html>