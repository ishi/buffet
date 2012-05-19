<?php

class Core_Dir {
	static function remove_dir($dir) { 
		if (!is_dir($dir) || is_link($dir)) return unlink($dir); 
		
		foreach (scandir($dir) as $file) { 
			if ($file == '.' || $file == '..') continue; 
			if (!$this->remove_dir($dir . DIRECTORY_SEPARATOR . $file)) { 
				chmod($dir . DIRECTORY_SEPARATOR . $file, 0777); 
				if (!$this->remove_dir($dir . DIRECTORY_SEPARATOR . $file)) return false; 
			};
		}
		return rmdir($dir); 
	}
}