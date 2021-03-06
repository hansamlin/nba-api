<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2018/11/30
 * Time: 下午 05:05
 */

require 'vendor/autoload.php';

$config         = new Config();
$mysql_address  = $config->mysql_address;
$mysql_username = $config->mysql_username;
$mysql_password = $config->mysql_password;
$mysql_database = $config->mysql_database;

$db = new DatabaseAccessObject($mysql_address, $mysql_username, $mysql_password, $mysql_database);


$table     = "nba_teamname";
$condition = "1 = :TeamID";

$order_by   = "";
$fields     = "";
$limit      = "";
$data_array = [":TeamID" => 1];

$Teams = $db->query($table, $condition, $order_by, $fields, $limit, $data_array);


$east = [];
$west = [];
foreach ($Teams as $team)
{
	if ($team["AREA"] == 'east')
	{
		$east[] = $team;
	}
	else
	{
		$west[] = $team;
	}
}
?>

<style>
    .content {
        margin: 0 auto;
        text-align: center;
    }

    .content div {
        display: inline-block;
        vertical-align: top;
    }

    img {
        height: 8em;
        width: 8em;
        vertical-align: middle;
    }

    table {
        width: 100%;
    }

    table tr td.category-table__text {
        text-align: center;
    }

    td {
        padding: 3em;
        font-size: .9375rem;
    }

    .category-header h1 {
        text-align: center;
    }

    .category-body {
        width: 100%;
        text-align: center;
    }

    a {
        text-decoration: none;
        color: #333;
    }
</style>


<div class="content">


    <div class="category">

        <div class="category-body">

            <table class="category-table">

                <tbody>
                <tr>
					<?php
					foreach ($Teams as $num => $team)
					{
						if ($num % 8 == 0 and $num > 0)
						{
							echo "</tr>";
							echo "<tr>";
						}
						?>

                        <td class="category-table__text">
                            <a class="stats-team-list__link" href="TeamName/<?php echo $team['Team_Name_En']; ?>/">
                                <img src="https://stats.nba.com/media/img/teams/logos/<?php echo $team['Team_Name_En'] ?>_logo.svg" alt="<?php echo $team["Team_Name_En"] ?> logo" title="<?php echo $team["Team_Name_En"]; ?> logo">
                        </td>

					<?php } ?>
                </tr>

                </tbody>
            </table>
        </div>


    </div>
</div>
