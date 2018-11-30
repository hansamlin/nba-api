<style>
    .scorebox_table {
        margin-bottom: 1%;
        text-align: center;
    }

    .scorebox_table td {
        width: 1%;
    }

    .scorebox_table img {
        width: 30%;
    }

    .scorebox_table {
        font-size: 2em;
    }
</style>

<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2018/11/21
 * Time: 下午 03:16
 */

require 'vendor/autoload.php';

$team_name = "";
if (isset($_GET["team_name"]))
{
	$team_name = utility::cleanText($_GET["team_name"]);
}

if (!$team_name)
{
	echo json_encode(["status" => "404 - not found"]);
	exit;
}

$game_num = "";
if (isset($_GET["num"]))
{
	$game_num = utility::cleanText($_GET["num"]);
}

$config         = new Config();
$mysql_address  = $config->mysql_address;
$mysql_username = $config->mysql_username;
$mysql_password = $config->mysql_password;
$mysql_database = $config->mysql_database;

$db = new DatabaseAccessObject($mysql_address, $mysql_username, $mysql_password, $mysql_database);

$table     = "nba_teamname";
//$condition = "Team_Name_Ch LIKE :Team_Name_Ch";
$condition = "Team_Name_En LIKE :Team_Name_En";

$order_by   = "";
$fields     = "";
$limit      = "";
//$data_array = [":Team_Name_Ch" => "%" . $team_name . "%"];
$data_array = [":Team_Name_En" => $team_name];

$results = $db->query($table, $condition, $order_by, $fields, $limit, $data_array);

if (!$results)
{
	echo json_encode(["status" => "404 - not found"]);
	exit;
}

foreach ($results as $num => $result)
{
	$TEAM_ID = $result["TeamID"];

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
	$limit      = $game_num;
	$data_array = [":TEAM_ID" => $TEAM_ID];

	$linescore = $db->query($table, $condition, $order_by, $fields, $limit, $data_array);

	$total = count($linescore);

	//Home
	$count_home = 0;

	//Visit
	$count_visit = 0;

	$pts        = [];
	$pts_home   = [];
	$pts_visit  = [];

	foreach ($linescore as $item)
	{
		$pts["PTS_QTR1"] += $item["PTS_QTR1"];
		$pts["PTS_QTR2"] += $item["PTS_QTR2"];
		$pts["PTS_QTR3"] += $item["PTS_QTR3"];
		$pts["PTS_QTR4"] += $item["PTS_QTR4"];

		$pts["first_half"]  += $item["PTS_QTR1"];
		$pts["first_half"]  += $item["PTS_QTR2"];
		$pts["second_half"] += $item["PTS_QTR3"];
		$pts["second_half"] += $item["PTS_QTR4"];

		if ($item["IS_HOME"])
		{
			$pts_home["PTS_QTR1"] += $item["PTS_QTR1"];
			$pts_home["PTS_QTR2"] += $item["PTS_QTR2"];
			$pts_home["PTS_QTR3"] += $item["PTS_QTR3"];
			$pts_home["PTS_QTR4"] += $item["PTS_QTR4"];

			$pts_home["first_half"] += $item["PTS_QTR1"];
			$pts_home["first_half"] += $item["PTS_QTR2"];

			$pts_home["second_half"] += $item["PTS_QTR3"];
			$pts_home["second_half"] += $item["PTS_QTR4"];

			$count_home += 1;
		} else
		{
			$pts_visit["PTS_QTR1"] += $item["PTS_QTR1"];
			$pts_visit["PTS_QTR2"] += $item["PTS_QTR2"];
			$pts_visit["PTS_QTR3"] += $item["PTS_QTR3"];
			$pts_visit["PTS_QTR4"] += $item["PTS_QTR4"];

			$pts_visit["first_half"]  += $item["PTS_QTR1"];
			$pts_visit["first_half"]  += $item["PTS_QTR2"];

			$pts_visit["second_half"] += $item["PTS_QTR3"];
			$pts_visit["second_half"] += $item["PTS_QTR4"];

			$count_visit += 1;
		}

	}

	echo "<div class='scorebox'>";
	echo "<table border='1' class='scorebox_table'>";
	echo "<tr>";
	echo "<th><img src=\"https://stats.nba.com/media/img/teams/logos/{$result['Team_Name_En']}_logo.svg\" alt=\" logo\" title=\" logo\"></th>";
	echo "<th>Q1</th>";
	echo "<th>Q2</th>";
	echo "<th>Q3</th>";
	echo "<th>Q4</th>";
	echo "<th>First half</th>";
	echo "<th>Second half</th>";
	echo "</tr>";


	echo "<tr>";
	echo "<td>";
	echo "主場";
	echo "</td>";

	foreach ($pts_home as $home)
	{
		echo "<td>";
		echo Avg($home, $count_home);
		echo "</td>";
	}

	echo "</tr>";

	echo "<tr>";
	echo "<td>";
	echo "客場";
	echo "</td>";

	foreach ($pts_visit as $visit)
	{
		echo "<td>";
		echo Avg($visit, $count_visit);
		echo "</td>";
	}

	echo "</tr>";


	echo "<tr>";
	echo "<td>";
	echo "Total";
	echo "</td>";

	foreach ($pts as $pt)
	{
		echo "<td>";
		echo Avg($pt, $total);
		echo "</td>";
	}

	echo "</tr>";

	echo "</table>";
	echo "</div>";

}

/**
 * @param $dividend
 * @param $divisor
 *
 * @return float|int
 */
function Avg($dividend, $divisor)
{
	return round($dividend / $divisor, 2);
}

