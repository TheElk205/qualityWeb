<?php 

echo get_web_page("localhost:8080/quality/" . $_GET['jobId'] . "/psnr/googleChart");
/*$psnrWhenInfinity = 100;

$response = get_web_page("localhost:8080/quality/test");
$json_rep = json_decode($response);
$status = $json_rep->{"status"};
if($status == "FINISHED") {
	$represenstations = $json_rep->{"results"};
	$numberResults = count($represenstations);
	$results = $represenstations[0]->{"results"};
	
	$chartJson = "{	'cols':[ {'label':'Frame number','type':'number'}";
	for($i = 0; $i < $numberResults; $i++) {
		 $chartJson = $chartJson . ",{'label':'PSNR (dB) " . $represenstations[$i]->{"bitrate"} . "','type':'number'}";
	}
	$chartJson = $chartJson . "],'rows':[";
	$col = 1;
	for($i = 0; $i < $numberResults; $i++) {
		$values[$i] = $represenstations[$i]->{"results"};
	}
	for($j = 0; $j < count($values[0]); $j++) {
		$chartJson = $chartJson . "{ 'c':[{'v':" . $col . "}";
		for($i = 0; $i < $numberResults; $i++) {
			$psnrvalue = $represenstations[$i]->{"results"}[$j];
			if($psnrvalue == "Infinity") {
				$chartJson = $chartJson . ",{'v': " . $psnrWhenInfinity . "}";
			}
			else {
				$chartJson = $chartJson . ",{'v': " . $psnrvalue . "}";
			}
			$col = $col +1;
		}
		$chartJson = $chartJson . "]},";
	}
	$chartJson = substr($chartJson, 0, strlen($chartJson)-1);
	$chartJson = $chartJson . "]}";
	$chartJson = str_replace("'", "\"", $chartJson);

	echo $chartJson;
}
else {
	echo "{}";
}
*/
function get_web_page($url) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
    ); 

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    curl_close($ch);

    return $content;
}

?>