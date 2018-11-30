<?php

Class PtsQtr {

	/**
	 * @param $team_name
	 *
	 * @return array
	 */
	public function getTeamID($team_name) {

		$model  = new PtsQtrModel();
		$result = $model->getTeamID($team_name);

		if (!$result) {
			echo json_encode(["status" => "404 - not found"]);
			exit;
		}

		return $result;
	}

	/**
	 * @param $team_id
	 */
	public function getQtsAvg($teams) {

		$model     = new PtsQtrModel();

		foreach ($teams as $team) {

			$linescore = $model->getPtsQtr($team);

			$total = count($linescore);

			//Home
			$count_home = 0;

			//Visit
			$count_visit = 0;

			$pts       = [];
			$pts_home  = [];
			$pts_visit = [];
			foreach ($linescore as $item) {

				$pts["PTS_QTR1"] += $item["PTS_QTR1"];
				$pts["PTS_QTR2"] += $item["PTS_QTR2"];
				$pts["PTS_QTR3"] += $item["PTS_QTR3"];
				$pts["PTS_QTR4"] += $item["PTS_QTR4"];

				if ($item["IS_HOME"]) {
					$pts_home["PTS_QTR1"] += $item["PTS_QTR1"];
					$pts_home["PTS_QTR2"] += $item["PTS_QTR2"];
					$pts_home["PTS_QTR3"] += $item["PTS_QTR3"];
					$pts_home["PTS_QTR4"] += $item["PTS_QTR4"];
					$count_home           += 1;
				} else {
					$pts_visit["PTS_QTR1"] += $item["PTS_QTR1"];
					$pts_visit["PTS_QTR2"] += $item["PTS_QTR2"];
					$pts_visit["PTS_QTR3"] += $item["PTS_QTR3"];
					$pts_visit["PTS_QTR4"] += $item["PTS_QTR4"];
					$count_visit           += 1;
				}

			}
			echo "<div class='scorebox'>";
			echo "<table border='1' class='scorebox_table'>";
			echo "<tr>";
			echo "<th><img src=\"https://stats.nba.com/media/img/teams/logos/{$team['Team_Name_En']}_logo.svg\" alt=\" logo\" title=\" logo\"></th>";
			echo "<th>Q1</th>";
			echo "<th>Q2</th>";
			echo "<th>Q3</th>";
			echo "<th>Q4</th>";
			echo "</tr>";


			echo "<tr>";
			echo "<td>";
			echo "主場";
			echo "</td>";

			foreach ($pts_home as $home) {
				echo "<td>";
				echo $this->Avg($home, $count_home);
				echo "</td>";
			}

			echo "</tr>";

			echo "<tr>";
			echo "<td>";
			echo "客場";
			echo "</td>";

			foreach ($pts_visit as $visit) {
				echo "<td>";
				echo $this->Avg($visit, $count_visit);
				echo "</td>";
			}

			echo "</tr>";


			echo "<tr>";
			echo "<td>";
			echo "Total";
			echo "</td>";

			foreach ($pts as $pt) {
				echo "<td>";
				echo $this->Avg($pt, $total);
				echo "</td>";
			}

			echo "</tr>";

			echo "</table>";
			echo "</div>";

		}

	}

	/**
	 * @param $dividend
	 * @param $divisor
	 *
	 * @return float
	 */
	public function Avg($dividend, $divisor) {
		return round($dividend / $divisor, 2);
	}

}