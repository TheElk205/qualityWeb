<?php
/*require_once("bitcodin/Bitcodin.php");
require_once("bitcodin/Apiresource.php");
require_once("bitcodin/EncodingProfile.php");
require_once("GuzzleHttp/Client.php");
require_once("GuzzleHttp/ClientInterface.php");
*/

include "vendor/autoload.php";

use bitcodin\Bitcodin;
use bitcodin\EncodingProfile;
use bitcodin\Job;

include 'cssmenu/header.html';
session_start();
// Ask for Api key, Not reqired. If Api key is not set, no usable Outputs wil be printed
if(isset($_SESSION['post_data'])) {
    echo "Already logged in </br>";
    $_POST['apiKey'] = $_SESSION['post_data']['apiKey'];
}
if( !isset($_POST['apiKey'] )) {
	echo "Create new Quality:<br />";
	echo "<form action='createQuality.php' method='post'>
	 <p>Bitmovin Api Key <input type='text' value='' name='apiKey' /></p>
	 <p><input type='submit' /></p>
	</form>";
}
else if(isset($_POST['newId'])) {
	echo "Job created with ID: " . $_POST['newId'];
}
else {
	echo "<script type='text/javascript'>

        function handleTableClick(evt) {
            var node = evt.target || evt.srcElement;
            if (node.name == 'setUrls') {
               location.replace(location.href + '?orig=document.getElementById(\'newOrigUrl\').value');
               window.location.reload(true);
            }
        }

    </script>";
    $_SESSION['post_data'] = $_POST;
	$apiKey = $_POST['apiKey'];
	Bitcodin::setApiToken($apiKey);
	$jobs = Job::getList();

	echo "<table border='1' id='showJobs' >
			<thead>
				<tr>
					Encoding ID
				</tr>
				<tr>
					Input ID
				</tr>
				<tr>
                    Calculate Quality
                </tr>
			</thead>
			<tbody>";
	foreach($jobs->jobs as $job)
		if($job->status == "Finished")
			echo "<tr><td>" . $job->jobId . "</td><td>" . $job->input->inputId . "</td>
			<td><form name='f1' method='get'>
			        <input name='orig' type='hidden' id='newOrigUrl' value=" . $job->input->url . ">
			        <input name='mpd' type='hidden' id='newMpdUrl' value=" . json_decode(json_encode($job->manifestUrls),true)['mpdUrl'] . ">
			        <button name='setUrls'  >Get Urls</form>
               </form>
               </td>";
			echo "</tbody></table>";
	
	if(!isset($_POST['urlOriginal'] ) || !isset($_POST['urlMpd'] )) {
        if(isset($_GET['orig']))
            $orig = $_GET['orig'];
        else
            $orig ="";
        if(isset($_GET['mpd']))
            $mpd = $_GET['mpd'];
        else
            $mpd = "";
		echo "<form action='createQuality.php' method='post'>
		 <p>Original Video:<input type='text' name='urlOriginal' value='" . $orig . "' required/>
		 MPD Url:<input type='text' name='urlMpd' value='" . $mpd . "' required/></p>
		 <input type='hidden' name='apiKey' value='".$apiKey . "'/>
		 <p><input type='submit' value='Start Quality' /></p>
		</form>";
	}
	else {
		// where are we posting to?
		$url = 'localhost:8080/quality/dash';
		
		// what post fields?
		$fields = array(
		   'source' => $_POST['urlOriginal'],
		   'mpd' => $_POST['urlMpd'],
		);
		
		// build the urlencoded data
		$postvars = http_build_query($fields);
		
		// open connection
		$ch = curl_init();
		
		// set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		
		// execute post
		$result = curl_exec($ch);
		// close connection
		curl_close($ch);
		echo "Job Created with ID: " . $result;
	}
}
include 'cssmenu/footer.html';
?>