<?php
function download_url($url)
{
	
	$user_agent="Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
	$html_content = curl_exec($ch);
	curl_close($ch);
	
	return $html_content;
}

?>