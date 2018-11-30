<?php

class SiteNbaHandler extends SimpleRest {

	//	function getAllSites() {
	//		//		$site    = new Site();
	//		//		$rawData = $site->getAllSite();
	//		//
	//		//		if (empty($rawData)) {
	//		//			$statusCode = 404;
	//		//			$rawData    = array ('error' => 'No sites found!');
	//		//		} else {
	//		//			$statusCode = 200;
	//		//		}
	//		//
	//		//		$requestContentType = $_SERVER['HTTP_ACCEPT'];
	//		//		$this->setHttpHeaders($requestContentType, $statusCode);
	//		//		$requestContentType = 'application/json';
	//		//		if (strpos($requestContentType, 'application/json') !== false) {
	//		//			$response = $this->encodeJson($rawData);
	//		//			echo $response;
	//		//		} else if (strpos($requestContentType, 'text/html') !== false) {
	//		//			$response = $this->encodeHtml($rawData);
	//		//			echo $response;
	//		//		} else if (strpos($requestContentType, 'application/xml') !== false) {
	//		//			$response = $this->encodeXml($rawData);
	//		//			echo $response;
	//		//		}
	//	}

	function Qtr($team_name) {
		$PtsQtr  = new PtsQtr();
		$team_id = $PtsQtr->getTeamID($team_name);
		$PtsQtr->getQtsAvg($team_id);

		//		if (empty($rawData)) {
		//			$statusCode = 404;
		//			$rawData    = array (
		//				'error'  => 'No data found!',
		//				'status' => 0
		//			);
		//		} else {
		//		$statusCode = 200;
		//			$rawData['status'] = 1;
		//		}

		//		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		//		$this->setHttpHeaders($requestContentType, $statusCode);

		//		$response = $this->encodeJson($rawData);
		//		echo $response;
	}

	public function encodeHtml($responseData) {

		$htmlResponse = "<table border='1'>";
		foreach ($responseData as $key => $value) {
			$htmlResponse .= "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
		}
		$htmlResponse .= "</table>";

		return $htmlResponse;
	}

	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);

		return $jsonResponse;
	}

	public function encodeXml($responseData) {
		$xml = new SimpleXMLElement('<?xml version="1.0"?><site></site>');
		foreach ($responseData as $key => $value) {
			$xml->addChild($key, $value);
		}

		return $xml->asXML();
	}

}