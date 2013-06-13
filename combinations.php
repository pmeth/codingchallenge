<?php

if (!isset($argv[1])) {
	error(1, 'Argument not set');
}

if (!is_numeric($argv[1])) {
	error(2, 'Argument must be a number');
}

if ($argv[1] < 1) {
	error(3, 'Argument must be greater than or equal to 1');
}


$min = 1;
$max = $argv[1];
foreach (combinations(range($min, $max)) as $combination) {
	println($combination);
}

function combinations(array $buttons) {
	$return = array();
	foreach ($buttons as $key => $button) {
		$newbuttons = $buttons;
		unset($newbuttons[$key]);
		$combinations = combinations($newbuttons);
		$return[] = $button;
		foreach($combinations as $combination) {
			// do combinations that include button
			$return[] = $button . ' ' . $combination;
			// do combinations that don't include button
			$return[] = $combination;

		}

		$newbuttons2 = $newbuttons;
		foreach ($newbuttons2 as $key2 => $button2) {
			if ($button2 < $button) {
				continue;
			}
			unset($newbuttons2[$key2]);
			$combinations = combinations($newbuttons2);
			$return[] = $button . '-' . $button2;
			foreach($combinations as $combination) {
				// do combinations that include multi button
				$return[] = $button . '-' . $button2 . ' ' . $combination;

			}
		}


	}

	// remove duplicates
	return array_unique($return);
}

function error($code, $message = '') {
	println('Error [' . $code . ']: ' . $message);
	println('Usage: php ' . $_SERVER['SCRIPT_NAME'] . ' {N}');
	exit($code);
}

function println($string) {
	echo $string . "\n";
}
