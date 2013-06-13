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

	return array_unique($return);
}
