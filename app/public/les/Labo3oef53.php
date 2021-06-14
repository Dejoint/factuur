<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labo 03 - oefening 4</title>
    <?php
        $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
        $bedrijf = isset($_SESSION['bedrijf']) ? $_POST['bedrijf'] : '';
        $land = isset($_SESSION['land']) ? $_SESSION['land'] : '';
    	$voorkeur = isset($_SESSION['voorkeur']) ? $_SESSION['voorkeur'] : '';
    	$foodr = isset($_SESSION['foodr']) ? $_SESSION['foodr'] : '';
    	

    ?>
</head>
<body>

	

		<fieldset>

			<h2>Bevestiging inschrijving</h2>

			<dl class="clearfix">

				<dt>
					<label for="name">Naam: </label>
					<p><?php echo $name; ?></p>
				</dt>
				
				<dd class="radio">
					<input type="radio" id="elo" name="voorkeur" value="elo">
  					<label for="elo">Elo</label><br>
  					<input type="radio" id="infra" name="voorkeur" value="infra">
  					<label for="infra">Infra</label><br>
  					<input type="radio" id="web" name="voorkeur" value="web">
  					<label for="web">Web</label><br>
  					<input type="radio" id="prog" name="voorkeur" value="prog">
  					<label for="prog">Prog</label>
					
				</dd>
				<dt><label for="foodr">Food Restrictions</label></dt>
				<dd class="text">
					<input type="text" id="bedrijf" name="bedrijf" value="<?php echo htmlentities($foodr); ?>" class="input-text" />
					<span class="message error"><?php echo $msgFoodr; ?></span>
				</dd>
				

				<dt class="full clearfix" id="lastrow">
					<input type="hidden" name="moduleAction" value="processName" />
					<input type="submit" id="btnSubmit" name="btnSubmit" value="Send" />
				</dt>

			</dl>

		</fieldset>

	
	
</body>
</html>