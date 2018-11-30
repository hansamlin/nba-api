<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2018/11/22
 * Time: 上午 10:45
 */

class utility {
	// 取得網頁結果
	public static function curlAPI($_url, $_method, $_param, $join = false) {
		unset($result);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		switch ($_method) {
			case "GET":
				if ($join) {
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				}
				$_url .= '?' . http_build_query($_param);
				break;
			case "POST":
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_param));
				break;
			case "PUT":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_param));
				break;
			case "DELETE":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_param));
				break;

			default:
				break;
		}


		curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Accept: application/json'));
		curl_setopt($ch, CURLOPT_URL, $_url);
		$api_response = curl_exec($ch);
		$code         = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$message      = curl_error($ch);

		curl_close($ch);

		if ($code == 200) {
			return $api_response;
		} else {

			return false;
		}

	}

	public static function cleanText(&$text) {
		$text = preg_replace("'<script[^>]*>.*?</script>'si", '', $text);
		$text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text);
		$text = preg_replace('/<!--.+?-->/', '', $text);
		$text = preg_replace('/{.+?}/', '', $text);
		$text = preg_replace('/&nbsp;/', ' ', $text);
		$text = preg_replace('/&amp;/', ' ', $text);
		$text = preg_replace('/&quot;/', ' ', $text);
		$text = strip_tags($text);
		$text = htmlspecialchars($text, ENT_COMPAT, 'UTF-8');

		return $text;
	}
}