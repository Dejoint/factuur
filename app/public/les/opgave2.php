<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labo 02 - oefening 2</title>
</head>
<body>
	<pre><?php
        // enter your PHP code here
		$zin = '"Wat was was, voor dat was was was? Dat weet ik niet... Was?';
		$frequenties = array();
		echo $zin . PHP_EOL;
		$deel = explode(" ", $zin);
		foreach ($deel as $woord => $value) {
			$deel[$woord] = trim($value, ",?.!");
		}
		foreach ($deel as $key => $value) {
			if (array_key_exists(strtolower($value), $frequenties)) {
				$frequenties[strtolower($value)]++;
			}
			else{
				$frequenties[strtolower($value)] = 1;
			}
		}
		asort($frequenties)	;	
		print_r($frequenties);
		
?>
	</pre>
</body>
</html>

