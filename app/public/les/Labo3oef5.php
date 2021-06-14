<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labo 03 - oefening 5</title>
    <?php
    	session_start();
    	$moduleAction = isset($_SESSION['moduleAction']) ? $_SESSION['moduleAction'] : '';
    	$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
    	$bedrijf = isset($_SESSION['bedrijf']) ? $_POST['bedrijf'] : '';
    	$land = isset($_SESSION['land']) ? $_SESSION['land'] : '';
    	

    	$part1 = false;
    	$msgName = "*";
    	$msgBedrijf = '*';
    	$msgLand = '*';
    	$msgVoorkeur = '*';

    	if ($moduleAction == 'processName') {
    		$check = true;
    		if ($land == 0) {
    			$msgLand = 'Duid een land aan.';
    			$check = false;
    		}
    		if (empty($name)) {
    			$msgName = 'Geef een naam in.';
    			$check = false;
    		}
    		if (empty($bedrijf)) {
    			$msgBedrijf = 'Geef een bedrijf in.';
    			$check = false;
    		}
    		if ($check) {
    			
				$part1 = true;
				header('Location: Labo3oef52.php');
				
    		}
    	}
    /*	else {
    		$name = (string) isset($_COOKIE[$name]) ? $_COOKIE[$name]:'';
			$bedrijf = (string) isset($_COOKIE[$bedrijf]) ? $_COOKIE[$bedrijf]:'';
			$land = (string) isset($_COOKIE[$land]) ? $_COOKIE[$land]:'';
    	}*/

    ?>
</head>
<body>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

		<fieldset>

			<h2>Schrijf je in voor onze conferentie</h2>

			<dl class="clearfix">

				<dt><label for="name">Naam</label></dt>
				<dd class="text">
					<input type="text" id="name" name="name" value="<?php echo htmlentities($name); ?>" class="input-text" />
					<span class="message error"><?php echo $msgName; ?></span>
				</dd>
				<dt><label for="bedrijf">Bedrijf</label></dt>
				<dd class="text">
					<input type="text" id="bedrijf" name="bedrijf" value="<?php echo htmlentities($bedrijf); ?>" class="input-text" />
					<span class="message error"><?php echo $msgBedrijf; ?></span>
				</dd>
				<dt><label for="land">Land</label></dt>
				<dd>
					<select name="land" id="land">
						<option value="0"<?php if ($land == 0) { echo ' selected="selected"'; } ?>>Please select...</option>
						<option value="1"<?php if ($land == 1) { echo ' selected="selected"'; } ?>>België</option>
						<option value="2"<?php if ($land == 2) { echo ' selected="selected"'; } ?>>Nederland</option>
						<option value="3"<?php if ($land == 3) { echo ' selected="selected"'; } ?>>Frankrijk</option>
						<option value="4"<?php if ($land == 4) { echo ' selected="selected"'; } ?>>Duitsland</option>
						<option value="5"<?php if ($land == 5) { echo ' selected="selected"'; } ?>>Spanje</option>
						
						
					</select>
					<span class="message error"><?php echo $msgLand; ?></span>
				</dd>

				<dt class="full clearfix" id="lastrow">
					<input type="hidden" name="moduleAction" value="processName" />
					<input type="submit" id="btnSubmit" name="btnSubmit" value="Send" />
				</dt>

			</dl>

		</fieldset>

	</form>
	
</body>
</html>