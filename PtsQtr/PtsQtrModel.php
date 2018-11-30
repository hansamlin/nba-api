<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2018/11/22
 * Time: 上午 11:26
 */

class PtsQtrModel extends Config {
	private $db;

	public function __construct() {
		$config         = new Config();
		$mysql_address  = $config->mysql_address;
		$mysql_username = $config->mysql_username;
		$mysql_password = $config->mysql_password;
		$mysql_database = $config->mysql_database;
		$this->db       = new DatabaseAccessObject($mysql_address, $mysql_username, $mysql_password, $mysql_database);
	}

	public function getTeamID($team_name) {

		$table     = "nba_teamname";
		$condition = "Team_Name_Ch LIKE :Team_Name_Ch";

		$order_by   = "";
		$fields     = "";
		$limit      = "";
		$data_array = [":Team_Name_Ch" => "%" . $team_name . "%"];

		$results = $this->db->query($table, $condition, $order_by, $fields, $limit, $data_array);

		return $results;
	}

	public function getPtsQtr($team){
		$table     = "nba_linescore";
		$condition = "TEAM_ID = :TEAM_ID";
		$order_by  = "GAME_DATE_EST DESC";

		$column     = [
			"PTS_QTR1",
			"PTS_QTR2",
			"PTS_QTR3",
			"PTS_QTR4",
			"IS_HOME"
		];
		$fields     = implode(",", $column);
		$limit      = "";
		$data_array = [":TEAM_ID" => $team["TeamID"]];

		$results = $this->db->query($table, $condition, $order_by, $fields, $limit, $data_array);

		return $results;
	}
}