<?php

print_r(combinations(range(1, 3)));

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
	}

	return array_unique($return);
}
