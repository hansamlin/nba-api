<link rel=stylesheet type="text/css" href="css.css">
<?php
require 'vendor/autoload.php';

$action = "";
if (isset($_GET["action"])) {
	$action = utility::cleanText($_GET["action"]);
}

$team_name = "";
if (isset($_GET["team_name"])) {
	$team_name = utility::cleanText($_GET["team_name"]);
}

if (!$action) {
	echo json_encode(["status" => "404 - not found"]);
	exit;
}

if (!$team_name) {
	echo json_encode(["status" => "404 - not found"]);
	exit;
}

/*
 * RESTful service 控制器
 *
*/

switch ($action) {

	case "Qtr":
		// 處理 REST Url /NBA/{}/
		$siteNbaHandler = new SiteNbaHandler();
		$siteNbaHandler->Qtr($team_name);
		break;

	//	case "getBalance":
	//		// 處理 REST Url /BCServer/getBalance/
	//		$siteRestHandler = new SiteRestHandler();
	//		$siteRestHandler->getBalance();
	//		break;
	//
	//	case "transaction":
	//		// 處理 REST Url /BCServer/transaction/
	//		$siteRestHandler = new SiteRestHandler();
	//		$siteRestHandler->transaction();
	//		break;
	//
	//	case "canceltrans":
	//		// 處理 REST Url /BCServer/canceltrans/
	//		$siteRestHandler = new SiteRestHandler();
	//		$siteRestHandler->canceltrans();
	//		break;
	//
	//	case "translog":
	//		// 處理 REST Url /BCServer/translog/
	//		$siteRestHandler = new SiteRestHandler();
	//		$siteRestHandler->translog();
	//		break;

	case "" :
		//404 - not found;
		echo json_encode(["status" => "404 - not found"]);
		break;
}