<?php
//error_reporting(0); // disable errors

use voku\helper\HtmlDomParser;
require_once 'include/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
if( empty($_SESSION["user"]) ){
	error("User not logged in", 1);
	exit;
} 


parse_str($_SERVER['QUERY_STRING'], $queries);
if( empty($queries["options"]) ) {
	error('Data query invalid', 2);
	exit;
}

$json_params = file_get_contents("php://input");

if (strlen($json_params) > 0 and isValidJSON($json_params)){
	$decoded_params = json_decode($json_params, true);
} else {
	error('Data JSON invalid', 3);
	exit;		
}


if($queries["options"] == 'text'){
	saveText($decoded_params);
}
if($queries["options"] == 'content'){
	saveContent($decoded_params);
}

function saveText($decoded_params){

	$id = $decoded_params['id'];
	$html = $decoded_params['html'];
			
	$html = strip_tags($html, '<br>');
	if ($html == '') {
		$html = '&nbsp';
	}
	
	$fileId = explode('_', trim($id));
	$fileName = 'themes/' . $fileId[0] . '/' . $fileId[1] . '.phtml';
	
	$dom = HtmlDomParser::file_get_html($fileName);
	
	$content = $dom->findOneOrFalse('#'.$id);
	if($content) {
		$content->innertext = $html;
	}

	$dom->save($fileName);
	res_OK();
}

function saveContent($decoded_params){
	$file = '/themes/'. $decoded_params['pathName'];
	file_put_contents($file, $decoded_params['html']);
	
	res_OK();
}

function isValidJSON($str) {
   json_decode($str);
   return json_last_error() == JSON_ERROR_NONE;
}

function error($msg, $code) {
	$response = ['error' => ['msg' => $msg,	'code' => $code]];
	echo json_encode($response, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
}

function res_OK() {
	$response = ['data' => 'OK'];
	echo json_encode($response, JSON_FORCE_OBJECT);
}
?>

