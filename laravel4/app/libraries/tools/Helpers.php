<?php

class Helpers {
	static function charsetDecode($s) {
		return htmlentities($s,ENT_COMPAT,'ISO-8859-1');
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

}