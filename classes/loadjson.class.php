<?php
class LoadJSON{
	const URL_JSON = "http://datos.labplc.mx/";

	public static function load($api, $option, $data){
		$url_data = self::URL_JSON . "$api/$option/$data.json";
		$json = file_get_contents($url_data);
		$data_json = json_decode($json);
		return $data_json;
	}
}
?>