<?php

require 'vendor/autoload.php';

$GameDate  = date("m/d/Y", time() - 86400);
$LeagueID  = "00";
$DayOffset = "0";
//$GameDate  = "11/25/2018";

$_param = [
	"GameDate"  => $GameDate,
	"LeagueID"  => $LeagueID,
	"DayOffset" => $DayOffset
];
$_url   = "https://stats.nba.com/stats/scoreboard/";
$_url   .= '?' . http_build_query($_param);

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_URL, $_url);

$headers   = array ();
$headers[] = "Dnt: 1";
$headers[] = "Accept-Language: en";
$headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36";
$headers[] = "Accept: application/json";
$headers[] = "Referer: http://stats.nba.com/";
$headers[] = "Connection: keep-alive";
$headers[] = "Content-Type: application/json";
$headers[] = "origin: http://stats.nba.com";

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


$api_response = curl_exec($ch);
$code         = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$message      = curl_error($ch);

curl_close($ch);

$response = json_decode($api_response);

$config         = new Config();
$mysql_address  = $config->mysql_address;
$mysql_username = $config->mysql_username;
$mysql_password = $config->mysql_password;
$mysql_database = $config->mysql_database;

$db = new DatabaseAccessObject($mysql_address, $mysql_username, $mysql_password, $mysql_database);

$table     = "nba_linescore";
$condition = "1 = :num";

$order_by   = "GAME_ID DESC";
$fields     = "DISTINCT GAME_ID";
$limit      = "";
$data_array = [":num" => 1];

$results = $db->query($table, $condition, $order_by, $fields, $limit, $data_array);


$GameHeader      = $response->resultSets[0]->headers;
$pos_hometeamid  = array_search("HOME_TEAM_ID", $GameHeader);
$pos_visitteamid = array_search("VISITOR_TEAM_ID", $GameHeader);

$GamerowSet = $response->resultSets[0]->rowSet;
foreach ($GamerowSet as $item) {
	$home[]  = $item[$pos_hometeamid];
	$visit[] = $item[$pos_visitteamid];
}

$headers = $response->resultSets[1]->headers;
$rowSet  = $response->resultSets[1]->rowSet;

$game_time = $rowSet[0];


foreach ($results as $result) {
	if (in_array($result["GAME_ID"], $game_time)) {
		die();
	}
}

if (!empty($rowSet)) {

	$data_array = [];
	foreach ($rowSet as $key => $item) {
		foreach ($item as $field => $value) {
			$data_array[$headers[$field]] = $value;
		}

		if (in_array($item[3], $home)) {
			$data_array["IS_HOME"] = 1;
		} else {
			$data_array["IS_HOME"] = 0;
		}

		$db->insert("nba_linescore", $data_array);
	}

}