<?php
session_start();

require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase(); 

$formErrors = array();

$categorie = array('frisdrank', 'versnaperingen', 'bier', 'andere');

$stmt = $db->prepare('SELECT * FROM verkoop ORDER BY categorie;');
$stmt->execute();
$verkoop = $stmt->fetchAll(PDO::FETCH_ASSOC);

$newArt = isset($_POST['newArt']) ? $_POST['newArt'] : '';
$newPrice = isset($_POST['newPrice']) ? $_POST['newPrice'] : '';
$newCat = isset($_POST['newCat']) ? $_POST['newCat'] : '';

$delId = isset($_POST['delId']) ? $_POST['delId'] : '';

$editId = isset($_POST['editId']) ? $_POST['editId'] : '';
$editArt = isset($_POST['editArt']) ? $_POST['editArt'] : '';
$editPrice = isset($_POST['editPrice']) ? $_POST['editPrice'] : '';
$editCat = isset($_POST['editCat']) ? $_POST['editCat'] : '';



if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'delete')) {
	$stmt = $db-> prepare('DELETE FROM verkoop WHERE id = ?');
	$stmt->execute([$delId]);
	header('Location:artikels.php');
	exit();
}

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'edit')) {
	if (trim($editArt) === '') {
		$formErrors[] = 'Gelieve een artikelnaam in te geven.';
	};
	if (is_double(trim($editPrice))) {
		$formErrors[] = 'Gelieve een getal te gebruiken';
	}
	if ($editCat == '0') {
		$formErrors[] = 'Gelieve een categorie te kiezen.';
	}
	if (count($formErrors) == 0) {
		$stmt = $db->prepare('UPDATE verkoop SET naam = ?, categorie = ?, prijs = ? WHERE id = ?');
		$stmt->execute([$editArt, $editCat, $editPrice, $editId]);
		header('Location: artikels.php');
		exit();
	}
}

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'submit')) {

$stmt = $db-> prepare('SELECT COUNT(*) FROM verkoop WHERE naam = ?;');
$stmt->execute([$newArt]);
$checkIfExits = $stmt->fetch(PDO::FETCH_ASSOC);

if (trim($newArt) === '') {
		$formErrors[] = 'Gelieve een artikelnaam in te geven.';
	};
	if (is_double(trim($newPrice))) {
		$formErrors[] = 'Gelieve een getal te gebruiken';
	}
	
	if ($checkIfExits["COUNT(*)"] != '0') {
		$formErrors[] = 'Er bestaat al een artikel met deze naam';
	}
	if (count($formErrors) == 0) {
		$stmt = $db-> prepare('INSERT INTO verkoop (naam, prijs, categorie) VALUES (?,?,?)');
		$stmt->execute(array($newArt, $newPrice, $newCat));
		header('Location: artikels.php');
		exit();
	};

};

?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="UTF-8">
	<title>Artikels</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/aa9a352006.js" crossorigin="anonymous"></script>
	

</head>
<body>
<?php require_once('header.php') ?>
	<div class="container">
		<div class="col">
		<h1 class="h2">Artikel toevoegen</h1>
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
						<label for="newArt" class="col-sm-3 control-label">Naam</label>

						<div class="col-sm-9">
							<input type="text" name="newArt" id="newArt" class="form-control" value="" placeholder="Naam artikel" required>
						</div>
					</div>

					<div class="form-group">
						<label for="newPrice" class="col-sm-3 control-label">Prijs</label>

						<div class="col-sm-9">
							<div class="input-group is-invalid">
							<div class="input-group-prepend">
        						<span class="input-group-text" id="validatedInputGroupPrepend">€</span>
      						</div>
							<input type="text" name="newPrice" id="newPrice" class="form-control" value="" placeholder="Prijs" required>
						</div>
					</div>
					</div>
					
					<div class="form-group">
						<label for="newType" class="col-sm-3 control-label">Categorie</label>
						<div class="col-sm-9">
							<select name="newCat" id="newCat" class="form-control" required>
								<option value="0">Kies...</option>
								<?php foreach ($categorie as $cat) {?>
									<option value="<?php echo htmlentities($cat)?>"><?php echo htmlentities($cat)?> </option>
								<?php } ?>
							</select>
						</div>
					</div>
					<input type="hidden" name="moduleAction" value="submit">
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
							<button type="submit" class="btn btn-default">
								<i class="fa fa-btn fa-plus"></i> Voeg artikel toe
							</button>
						</div>
					</div>
				</form>
		
		</div>
</div>
<h1 class="h2">Artikels</h1>
		<div class="col-md-9 ">
			<div class="table-responsive">
				<table class="table table-striped table-sm">
					<thead>
						<tr>
							
							<th>Naam</th>
							<th>Categorie</th>
							<th>Prijs</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						
						foreach ($verkoop as $artikel) {

							?>
							<tr>
								
								<td><?php echo htmlentities($artikel['naam'])?></td>
								<td><?php echo htmlentities($artikel['categorie'])?></td>
								<td><?php echo htmlentities('€' . $artikel['prijs'])?></td>
								<td>
									<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#editModal" data-id="<?php echo htmlentities($artikel['id']) ?>" data-name="<?php echo htmlentities($artikel['naam'])?>" data-prijs="<?php echo htmlentities($artikel['prijs'])?>">
										<i class="fa fa-btn fa-pencil"></i> Wijzigen
									</button>
								</td>
								<td>
										
										<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo htmlentities($artikel['id']) ?>" data-name="<?php echo htmlentities($artikel['naam']) ?>">
											<i class="fa fa-btn fa-trash"></i> Verwijderen
										</button>
										

									
								</td>
							</tr>
								<?php }
								?>
								
								
								
							</tbody>
						</table>
					</div>
			</div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form action="" method="POST" class="form-horizontal">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-footer">
      	<input  type="hidden" name="delId" id="delId" value="0">
      	<input type="hidden" name="moduleAction" value="delete">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
        <button type="submit" class="btn btn-danger">Verwijderen</button>
      </div>
  </form>
    </div>
  </div></div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 	
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" class="form-horizontal">
      <div class="modal-body">
      	<div class="form-group">
			<div class="col-sm-9">
				<div class="form-group">
						<label for="newArt" class="col-sm-3 control-label">Naam</label>

						<div class="col-sm-9">
							<input type="text" name="editArt" id="editArt" class="form-control" value="" placeholder="Naam artikel" required>
						</div>
					</div>

					<div class="form-group">
						<label for="newPrice" class="col-sm-3 control-label">Prijs</label>
						<div class="col-sm-9">
							<div class="input-group is-invalid">
							<div class="input-group-prepend">
        						<span class="input-group-text" id="validatedInputGroupPrepend">€</span>
      						</div>
							<input type="text" name="editPrice" id="editPrice" class="form-control" value="" placeholder="Prijs" required>
						</div>
					</div>
					</div>
					
					<div class="form-group">
						<label for="newType" class="col-sm-3 control-label">Categorie</label>
						<div class="col-sm-9">
							<select name="editCat" id="editCat" class="form-control" required>
								<option value="0">Kies...</option>
								<?php foreach ($categorie as $cat) {?>
									<option value="<?php echo htmlentities($cat)?>"><?php echo htmlentities($cat)?> </option>
								<?php } ?>
							</select>
						</div>
					</div>
			</div>
		</div>
      </div>
      <div class="modal-footer">
      	<input  type="hidden" name="editId" id="editId" value="0">
      	<input type="hidden" name="moduleAction" value="edit">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
  </form>
    </div>
  </div>
</div>

<script>
	$('#editModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var name = button.data('name')
  var categorie = button.data('categorie')
  var prijs = button.data('prijs')
  var modal = $(this)
  modal.find('.modal-title').text('Wijzigen: ' + name)
  modal.find('.modal-body input').val(name)
  document.getElementById("editId").value = id;
  document.getElementById('editPrice').value = prijs;
})
$('#deleteModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var name = button.data('name')
  var modal = $(this)
  modal.find('.modal-title').text('Weet u zeker dat u ' + name + ' wilt verwijderen?')
  modal.find('.modal-body input').val(name)
  document.getElementById("delId").value = id;
  console.log(id)
})
</script>
	</body>
	</html>