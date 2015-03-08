<?php

require_once("classes/abstract.coordinate.class.php");
//require_once("classes/user.class.php");

class Coordinate extends CoordinateBase{

	private $db;
	private $table;

	//public $user = new User();

	function __construct() {
		$this->table = strtolower(get_class($this));
		$this->db = new DB(Conf::$db_name, Conf::$db_host, Conf::$db_user, Conf::$db_pass);
	}

	public function getAll(){
		$return = array();
		$result = $this->db->query("SELECT * FROM $this->table");
		while ($row = $this->db->fetchNextObject($result)) {
			$return[] = $row;
		}
		return $return;
	}

	public function getByUserRide($userId, $rideId){
		$return = array();
		if($userId > 0 && $rideId > 0){
			$result = $this->db->query("SELECT id, x(coordinate) AS latitude, y(coordinate) AS longitude, ride_id, user_id, end_ride, panic, created FROM coordinate WHERE user_id = $userId AND ride_id = $rideId");
			while ($row = $this->db->fetchNextObject($result)) {
				$return[] = $row;
			}
		}
		return $return;
	}

	public function getCurrentPoints($userId, $rideId, $now){
		$return = array();
		if($userId > 0 && $rideId > 0 && !empty($now)){
			$result = $this->db->query("SELECT id, x(coordinate) AS latitude, y(coordinate) AS longitude, ride_id, user_id, end_ride, panic,  created FROM coordinate WHERE user_id = $userId AND ride_id = $rideId AND created > '$now'");
			while ($row = $this->db->fetchNextObject($result)) {
				$return[] = $row;
			}
		}
		return $return;	
	}

	public function getCurrentPoint($userId, $rideId, $now){
		$return = array();
		if($userId > 0 && $rideId > 0 && !empty($now)){
			$result = $this->db->query("SELECT id, x(coordinate) AS latitude, y(coordinate) AS longitude, ride_id, user_id, end_ride, panic,  created FROM coordinate WHERE user_id = $userId AND ride_id = $rideId AND created > '$now' ORDER BY created DESC LIMIT 1");
			while ($row = $this->db->fetchNextObject($result)) {
				$return[] = $row;
			}
		}
		return $return;	
	}

	public function setCoordinate($coordinate){
		return $this->db->execute("INSERT INTO $this->table (coordinate, ride_id, user_id, end_ride, panic) VALUES (POINT({$coordinate->coordinate}), {$coordinate->ride_id}, {$coordinate->user_id}, {$coordinate->end_ride}, {$coordinate->panic})");
	}

}

?>