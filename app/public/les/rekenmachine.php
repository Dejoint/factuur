<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labo 01 - oefening 3</title>
    <?php
        // enter your PHP code here
		$getal1 = isset($_GET['getal1']) ? (string) $_GET['getal1'] : '';
		$getal2 = isset($_GET['getal2']) ? (string) $_GET['getal2'] : '';
		$bewerking = isset($_GET['bewerking']) ? (string) $_GET['bewerking'] : 0;
		$btnSubmit = isset($_GET['btnSubmit']) ? (string) $_GET['btnSubmit'] : '' ;
		$getal1Msg ='*';
		$bewerkingMsg = '*';
		$getal2Msg = '*';
		$uitkomst = '';




		if ($btnSubmit == 'Reken uit') {
			$check = true;
			if ($bewerking == 0 || $bewerking >= 5) {
				$bewerkingMsg = 'Gelieve een teken te kiezen.';
				$check = false;
				$uitkomst = '';
			}
			if (!is_numeric($getal1)) {
				$getal1Msg = 'Gelieve een geldig getal in te geven.';
				$check = false;
				$uitkomst = '';
			}
			if (!is_numeric($getal2)) {
				$getal2Msg = 'Gelieve een geldig getal in te geven.';
				$check = false;
				$uitkomst = '';
			}
			if ($check) {
				setcookie('getal1', $getal1, time() + 60*60*24*7);
				setcookie('getal2', $getal2, time() + 60*60*24*7);
				setcookie('bewerking', $bewerking, time() + 60*60*24*7);
				
				switch ($bewerking) {
					case '1':
						$uitkomst = $getal1 + $getal2;
						break;
					case '2':
						$uitkomst = $getal1 - $getal2;
						break;
					case '3':
						$uitkomst = $getal1 * $getal2;
						break;
					case '4':
						$uitkomst = $getal1 / $getal2;
						break;
				}
			}
		}
		else {
    		$name = (string) isset($_COOKIE[$name]) ? $_COOKIE[$name]:'';
			$bedrijf = (string) isset($_COOKIE[$bedrijf]) ? $_COOKIE[$bedrijf]:'';
			$land = (string) isset($_COOKIE[$land]) ? $_COOKIE[$land]:'';
    	}

			

?>
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

		<fieldset>

			<h2>Rekenmachine</h2>

			<dl class="clearfix">

				<dt><label for="getal1">Getal 1</label></dt>
				<dd class="text"><input type="text" id="getal1" name="getal1" value="<?php echo htmlentities($getal1); ?>" class="input-text" /><?php echo htmlentities($getal1Msg);?></dd>
				
				<dt><label for="bewerking">Bewerking</label></dt>
					<dd>
					<select name="bewerking" id="bewerking">
						<option value="0"<?php if ($bewerking == 0) { echo ' selected="selected"'; } ?>>Please select...</option>
						<option value="1"<?php if ($bewerking == 1) { echo ' selected="selected"'; } ?>>+</option>
						<option value="2"<?php if ($bewerking == 2) { echo ' selected="selected"'; } ?>>-</option>
						<option value="3"<?php if ($bewerking == 3) { echo ' selected="selected"'; } ?>>*</option>
						<option value="4"<?php if ($bewerking == 4) { echo ' selected="selected"'; } ?>>/</option>
						
					</select>
					<?php echo htmlentities($bewerkingMsg);?>
				</dd>
				<dt><label for="getal2">Getal 2</label></dt>
				<dd class="text"><input type="text" id="getal2" name="getal2" value="<?php echo htmlentities($getal2); ?>" class="input-text" /><?php echo htmlentities($getal2Msg);?></dd>

				<dt class="full clearfix" id="lastrow">
					<input type="submit" id="btnSubmit" name="btnSubmit" value="Reken uit" />
					<?php echo htmlentities($uitkomst);?>
				</dt>

			</dl>

		</fieldset>

	</form>

</body>
</html>