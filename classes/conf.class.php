<?php
class Conf{
	public static $domain  = "";
	public static $db_host = "127.5.183.130";
	public static $db_user = "adminMPbazUV";
	public static $db_pass = "D_91S3afuq93";
	public static $db_name = "taximap";
	public static $time_zone = "America/Mexico_City";
}
date_default_timezone_set(Conf::$time_zone);
?>