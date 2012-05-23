<?php

class Core_Length {
	
	//sprawdzanie dlugosci zajawki
	static function checkLengthPreContent($src) {
		
		//maksymalna długość całej zajawki - 90 znakow
		$length = strlen(strip_tags($src));
		if ($length > 90) {
			return -1;
		}
		
		return 0;
		
		
	}
	
	
}