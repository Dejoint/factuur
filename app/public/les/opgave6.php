<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labo 03 - oefening 1</title>
    <?php
    	$name = isset($_GET['name']) ? (string) $_GET['name'] : '';
    	$btnSubmit = isset($_GET['btnSubmit']) ? (string) $_GET['btnSubmit'] : '' ;
    	$msgName = '*';
    	$msgLastName = '*';

    	if ($btnSubmit == 'Send') {
    		$check = true;
    		if (trim($name) == "") {
    			$check = false;
    			$msgName = "Gelieve een naam in te vullen";
    		}
    		if ($check) {
    			header('Location: success.php');
    			exit();
    		}
    	}

    ?>
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

		<fieldset>

			<h2>Form</h2>

			<dl class="clearfix">

				<dt><label for="name">Geef uw naam in.</label></dt>
				<dd class="text"><input type="text" id="name" name="name" value="" class="input-text" /><?php echo htmlentities($msgName);?></dd>
				<span class="message error"><?php echo ($name); ?></span>

				<dt class="full clearfix" id="lastrow">
					<input type="submit" id="btnSubmit" name="btnSubmit" value="Send" />
				</dt>
			</dl>
		</fieldset>
	</form>
</body>
</html>