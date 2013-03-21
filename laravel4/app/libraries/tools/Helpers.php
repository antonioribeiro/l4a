<?php

class Helpers {
	static function charsetDecode($s) {
		return $s; //htmlentities($s,ENT_COMPAT,'ISO-8859-1');
	}

	static function toArray($obj) {
		if(is_object($obj)) $obj = (array) $obj;
		if(is_array($obj)) {
			$new = array();
			foreach($obj as $key => $val) {
				$new[$key] = self::toArray($val);
			}
		}
		else {
			$new = $obj;
		}
		return $new;
	}

	static function englishDate($date) {
		list($d,$m,$y) = split('[/.-]',$date);
		return "$m/$d/$y";
	}

	static function brazilianDate($date) {
		list($d,$m,$y) = split('[/.-]',$date);
		echo "----> $d/$m/$y <br>";
		
		return "$d/$m/$y";
	}

}