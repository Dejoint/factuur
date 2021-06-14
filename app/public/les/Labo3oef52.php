<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labo 03 - oefening 4</title>
    <?php
    	$moduleAction = isset($_POST['moduleAction']) ? $_POST['moduleAction'] : '';
    	$voorkeur = isset($_SESSION['voorkeur']) ? $_SESSION['voorkeur'] : '';
    	$foodr = isset($_SESSION['foodr']) ? $_SESSION['foodr'] : '';
    	$msgVoorkeur = '*';
    	$msgFoodr = '*';

    	if ($moduleAction == 'processName') {
    		$check = true;
    		if (empty($voorkeur)) {
    			$msgVoorkeur= 'Duid een voorkeur aan.';
    			$check = false;
    		}
    		if (empty($foodr)) {
    			$msgName = '.';
    			$check = false;
    		}
    		
    		if ($check) {
    			header('Location: Labo3oef53.php');
    			exit();
    		}
    	}
    	/*else {
    		$name = (string) isset($_COOKIE[$name]) ? $_COOKIE[$name]:'';
			$bedrijf = (string) isset($_COOKIE[$bedrijf]) ? $_COOKIE[$bedrijf]:'';
			$land = (string) isset($_COOKIE[$land]) ? $_COOKIE[$land]:'';
    	}*/

    ?>
</head>
<body>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

		<fieldset>

			<h2>Schrijf je in voor onze conferentie Part 2</h2>

			<dl class="clearfix">

				<dt>
					<label for="voorkeur">Voorkeur</label>
					<span class="message error"><?php echo $msgVoorkeur; ?></span>
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

	</form>
	
</body>
</html>