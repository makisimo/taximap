<?php
class Conf{
	public static $domain  = "";
	public static $db_host = "localhost";
	public static $db_user = "root";
	public static $db_pass = "root";
	public static $db_name = "taxi";
	public static $time_zone = "America/Mexico_City";
}
date_default_timezone_set(Conf::$time_zone);
?>