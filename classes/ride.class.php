<?php

require_once("classes/abstract.ride.class.php");
//require_once("classes/user.class.php");

class Ride extends RideBase{

	//public $user = new User();
	private $db;
	private $table;

	function __construct() {
		$this->table = strtolower(get_class($this));
		$this->db = new DB(Conf::$db_name, Conf::$db_host, Conf::$db_user, Conf::$db_pass);
	}

	function getAll(){
		$return = array();
		$result = $db->query("SELECT * FROM ride");
		while ($row = $db->fetchNextObject($result)) {
			$return[] = $row;
		}
		return $return;
	}

	function setRide($ride){
		if($ride->comment != "NULL")
			$ride->comment = "'" . $this->db->real_escape_string($ride->comment) . "'";

		$this->db->execute("INSERT INTO $this->table (comment, `like`, end_time , user_id) VALUES ({$ride->comment}, {$ride->like}, {$ride->end_time}, {$ride->user_id})");

		return $this->db->lastInsertedId();
	}

	function setEndTime($id){
		return $this->db->execute("UPDATE $this->table SET end_time = NOW() WHERE id = $id");
	}

}

?>