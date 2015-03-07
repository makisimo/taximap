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
}
?>