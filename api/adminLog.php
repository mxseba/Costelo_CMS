<?php
//error_reporting(0); // disable errors

error_reporting(E_ALL);
ini_set('display_errors', '1');

parse_str($_SERVER['QUERY_STRING'], $queries);
date_default_timezone_set('Europe/Warsaw');
session_start();


if(!empty($queries["a"])) {
	switch($queries["a"])
	{
		case 'login';
			login();
			break;
		case 'logout';
			logout();
			break;
		default;
			error();
    		break;
	}
}


function login() {
	if (!empty($_POST['login']) && !empty($_POST['password']))
	{
	// var_dump($_POST);
  
		$login = 'admin';
		$hashPassword = '$2y$10$2OeXHe.8RFfizouqpp/3yOclVMuZVbvpU/AQX9CNJo2sKadHxLhga';
			
		//$hashPassword = password_hash($passToTest, PASSWORD_DEFAULT);
	
		
		if($_POST['login'] != $login) {
			header("Location: /admin/?a=errorLogin");
			return;
		}
		
		
		
		if (password_verify($_POST['password'], $hashPassword)) {
			$_SESSION['user'] = htmlspecialchars($_POST['login']);
			header("Location: /");
		} else {
			header("Location: /admin/?a=errorLogin");
			return;
		}
	} else {
		header("Location: /admin/?a=errorLogin");
	}
}

function logout() {
	unset($_SESSION['user']);
	session_destroy();
	header("Location: /");
}


function error(){
	return;		
}

?>

