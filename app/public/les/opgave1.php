<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labo 01 - oefening 3</title>
</head>
<body>
	<pre><?php
        // enter your PHP code here
		$firstName = 'Joran';
		$lastName = 'Anseau';
		echo 'hello world' . PHP_EOL;
		
		echo 'It\'s raining outside' . PHP_EOL;
		
		echo 'The value of $firstName is ' . $firstName . '. The value of $lastName is ' . $lastName . PHP_EOL;




		$alfabet = [];
		for ($i=0; $i < 26; $i++) { 
			$alfabet[] = chr(97 + $i);
		}
		//var_dump($alfabet);

		foreach ($alfabet as $key => $letter) {
			echo $key + 1 . $letter;
		}
		//var_dump($alfabet)
		echo PHP_EOL;

		echo implode(',', $alfabet) . PHP_EOL;
		echo count($alfabet) . PHP_EOL;
		echo array_shift($alfabet) . PHP_EOL;
		echo count($alfabet) . PHP_EOL;

		$cities = [9000 => 'Gent', 1000 => 'Brussel', 2000 => 'Antwerpen', 8500 => 'Kortrijk', 3000 => 'Leuven', 3500 => 'Hasselt'];
		$zips = array_keys($cities);
		print_r($zips);

		echo array_sum($zips);

		asort($cities);
		print_r($cities);

		ksort($cities);
		print_r($cities);
		$getal2 = 0;
		for ($i=0; $i < 10000; $i+=1000) { 
			if (array_key_exists(key, array)($cities[$i]) == true) {
				
			}
			echo $cities[$i];
			//echo ($i == $cities[$i]) ? 'true' : 'false';
		}


?>
	</pre>
</body>
</html>