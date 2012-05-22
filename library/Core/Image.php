<?php

class Core_Image {
	/**
	 *
	 * @param type $src Ścieżka do obrazka który przeskalować
	 * @param type $dest Ścieżka pod którą zapisać nowy plik
	 * @param array $options Parametry dla skalowania 
	 * <pre>
	 *		array(
	 *			'tw' => Szerokość obrazka wynikowego,
	 *			'th' => Wysokość obrazka wynikowego,
	 *			'x1' => Pozycja x lewego górnego rogu obszaru wycinanego w obrazku źródłowym,
	 *			'y1' => Pozycja y lewego górnego rogu obszaru wycinanego w obrazku źródłowym,
	 *			'w' => Szerokość wycinanego obszaru,
	 *			'h' => Wysokość wycinanego obszaru
	 *		)
	 * </pre>
	 */
	static function crop($src, $dest, array $options) {
		$type = strtolower(substr(strrchr($src,"."),1));
		if($type == 'jpg') $type = 'jpeg';
		switch($type){
				case 'bmp': $img = imagecreatefromwbmp($src); break;
				case 'gif': $img = imagecreatefromgif($src); break;
				case 'jpeg': $img = imagecreatefromjpeg($src); break;
				case 'png': $img = imagecreatefrompng($src); break;
				default : throw new Exception("Unsupported picture type!");
		}

		$new = ImageCreateTrueColor($options['tw'], $options['th']);
		// preserve transparency
		if($type == "gif" or $type == "png"){
				imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
				imagealphablending($new, false);
				imagesavealpha($new, true);
		}
		
		imagecopyresampled($new, $img, 0, 0, $options['x1'], $options['y1'],
				$options['tw'], $options['th'], $options['w'], $options['h']);

		if (null == $dest) {
			header("Content-type: image/$type");
		}
		switch($type){
			case 'bmp': imagewbmp($new, $dest, 100); break;
			case 'gif': imagegif($new, $dest, 100); break;
			case 'jpeg': imagejpeg($new, $dest, 100); break;
			case 'png': imagepng($new, $dest, 100); break;
		}
	}
	
	/**
	 *
	 * @param type $src Ścieżka do obrazka który przeskalować
	 * @param type $dest Ścieżka pod którą zapisać nowy plik
	 * @param array $options Parametry dla skalowania 
	 * <pre>
	 *		array(
	 *			'ratio' => ratio obrazka wynikowego,
	 *		)
	 * </pre>
	 */
	static function autocrop($src, $dest, array $options) {
		$ratio = $options['ratio'];
		
		$options['x1'] = $options['y1'] = 0;
		
		list($w, $h) = getimagesize($src);
		if ($w > $h * $ratio) {
			$options['x1'] = ($w - ($h * $ratio)) / 2; 
			$options['tw'] = $options['w'] = $h * $ratio;
			$options['th'] = $options['h'] = $h;
		} else {
			$options['y1'] = ($h - $w) / 2;
			$options['tw'] = $options['w'] = $w;
			$options['th'] = $options['h'] = $w * $ratio;
		}
		self::crop($src, $dest, $options);
	}
}