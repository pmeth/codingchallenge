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
$allbuttons = range($min, $max);

foreach (combinations($allbuttons) as $combination) {
	println($combination);
}

/**
 * This function will caluclate and return all possible combinations of button presses on a mechanical lock given the following restrictions:
 * * each button can only be used maximum of once in a combination
 * * a combination must have a length of at least 1
 *
 * @author	Peter Meth <pmeth@rogers.com>
 *
 * @param integer[]	$buttons A list of integers representing all the buttons on the lock
 * @return string[]	A list of possible combinations without duplicates.  Each element in the array is a string representing a valid combination.
 */
function combinations(array $buttons) {
	$return = array();
	foreach ($buttons as $key => $button) {
		$newbuttons = $buttons;
		unset($newbuttons[$key]);
		$combinations = combinations($newbuttons);
		$return[] = $button;
		foreach($combinations as $combination) {
			// do combinations that include this button
			$return[] = $button . ' ' . $combination;
			// do combinations that don't include this button
			$return[] = $combination;

		}

		// do combinations that include multi button
		$newbuttons2 = $newbuttons;
		foreach ($newbuttons2 as $key2 => $button2) {
			// combinations should always be listed with the lower number first
			if ($button2 < $button) {
				continue;
			}
			unset($newbuttons2[$key2]);
			$combinations = combinations($newbuttons2);
			$return[] = $button . '-' . $button2;
			foreach($combinations as $combination) {
				$return[] = $button . '-' . $button2 . ' ' . $combination;

			}
		}
	}

	// remove duplicates
	return array_unique($return);
}

/**
 * Prints an error to standard error, followed by the acceptable usage instructions
 *
 * @param string $code		A unique error code for this error
 * @param string $message	An optional message to include in the output
 *
 * @return void
 */
function error($code, $message = '') {
	fwrite(STDERR, 'Error [' . $code . ']: ' . $message . "\n");
	fwrite(STDERR, 'Usage: php ' . $_SERVER['SCRIPT_NAME'] . ' {N}' . "\n");
	exit($code);
}

/**
 * Prints the argument on a complete line to standard out
 *
 * @param string $string The message to be printed
 *
 * @return void
 */
function println($string) {
	echo $string . "\n";
}
