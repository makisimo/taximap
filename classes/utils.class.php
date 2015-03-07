<?php
class Utils{
	
	public static function p($string, $die = false){
		echo "<pre>";
		print_r($string);
		echo "</pre>";
		if($die)
			die("Por utils");
	}

	static public function verifyDate($date, $strict = true){
	    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $date);
	    if ($strict) {
	        $errors = DateTime::getLastErrors();
	        if (!empty($errors['warning_count'])) {
	            return false;
	        }
	    }
	    return $dateTime !== false;
	}

	static public function cleanInt($int){
		return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
	}

	static public function cleanFloat($float){
		return filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT);
	}

	static public function cleanCoordinate($coordinate){
		$coordinate_str = "";
		$chunks = explode(",", $coordinate);
		if(count($chunks) == 2){
			foreach ($chunks as $key => $chunk) {
				$coordinate_str .= $this->cleanFloat(trim($chunk)) . ",";
			}
			$coordinate_str = substr($coordinate_str, 0, -1);
		}
		return $coordinate_str;
	}

	static public function cleanString($string){
		
	}
}
?>