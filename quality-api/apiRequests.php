<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 24.11.2015
 * Time: 21:39
 */

function getD3Random($numberPoints, $numberSets) {
    $url = "localhost:8080/quality/test/d3";
    $fields = array(
        'numberPoints' => $numberPoints,
        'numberSets' => $numberSets
    );
    return postCall($url,$fields);
}

function getD3ForJob($jobId) {
    return getCall("localhost:8080/quality/" . $jobId . "/psnr/d3");
}

//Standard Getter
/**
 * @param $url Url to call
 * @return the return string from the server
 */
function getCall($url){

    // is cURL installed yet?
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }

    // OK cool - then let's create a new cURL resource handle
    $ch = curl_init();

    // Now set some options (most are optional)

    // Set URL to download
    curl_setopt($ch, CURLOPT_URL, $url);

    // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // Should cURL return or print out the data? (true = return, false = print)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    // Download the given URL, and return output
    $output = curl_exec($ch);

    // Close the cURL resource, and free system resources
    curl_close($ch);

    return $output;
}

//Standard POST
/**
 * @param $url Url to call
 * @param $fields array with parameter, e.g.
 *          $fields = array(
 *              'source' => $_POST['urlOriginal'],
 *              'mpd' => $_POST['urlMpd'],
 *          );
 * @return response from the Server
 */
function postCall($url, $fields)
{
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

    return $result;
}

?>