<?php

require_once("classes/abstract.ride.class.php");
//require_once("classes/user.class.php");

class Ride extends RideBase{

	//public $user = new User();
	private $db;

	function __construct() {
		$this->db = new DB($Conf::db_name, $Conf::host, $Conf::user, $Conf::pass);
	}

	function getAll(){
		$return = array();
		$result = $db->query("SELECT * FROM ride");
		while ($row = $db->fetchNextObject($result)) {
			$return[] = $row;
		}
		return $return;
	}

}

?>