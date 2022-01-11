<?php
error_reporting(0); // disable errors

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require("include/PHPMailer/src/PHPMailer.php");
require("include/PHPMailer/src/SMTP.php");
require("include/PHPMailer/src/Exception.php");

parse_str($_SERVER['QUERY_STRING'], $queries);
date_default_timezone_set('Europe/Warsaw');

if(!empty($queries["param"])) {
	switch($queries["param"])
	{
		case 'email';
			email();
			break;
		default;
			error();
    		break;
	}
}




function email() {
	if ( empty($_POST["email"]) ||  empty($_POST["message"])) {
		$response = ['error' => ['msg' => 'Przynajmniej jedno pole jest błędnie wypełnione. Sprawdź wpisaną treść i spróbuj ponownie.',
				'code' => 1]];
		echo json_encode($response, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
		return;		
	} else {
				
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet="UTF-8";
		$mail->Host = "mail.sqs-serwis.pl"; /* Zależne od hostingu poczty*/
		$mail->SMTPDebug = 0;
		$mail->Port = 465 ; /* Zależne od hostingu poczty, czasem 587 */
		$mail->SMTPSecure = 'ssl'; /* Jeżeli ma być aktywne szyfrowanie SSL */
		$mail->SMTPAuth = true;
		$mail->IsHTML(true);
		$mail->Username = "info@sqs-serwis.pl"; /* login do skrzynki email często adres*/
		$mail->Password = "MiChu121"; /* Hasło do poczty */
		$mail->setFrom($_POST["email"]); /* adres e-mail i nazwa nadawcy */
		$mail->AddAddress("info@sqs-serwis.pl"); /* adres lub adresy odbiorców */
		$subject = "Wiadomość z formularza";
		if(!empty($_POST["subject"])){
			$subject .=' - '.$_POST["subject"];
		}
	
		$mail->Subject = $subject; /* Tytuł wiadomości */
		$mail->Body = $_POST['message'];

		if(!$mail->Send()){
			$response = ['error' => ['msg' => 'Błąd wysyłania wiadomości.', 'code' => 8]];
			echo json_encode($response, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
			return;		
		}
		
		
		unset($mail);
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet="UTF-8";
		$mail->Host = "mail.sqs-serwis.pl"; /* Zależne od hostingu poczty*/
		$mail->SMTPDebug = 0;
		$mail->Port = 465 ; /* Zależne od hostingu poczty, czasem 587 */
		$mail->SMTPSecure = 'ssl'; /* Jeżeli ma być aktywne szyfrowanie SSL */
		$mail->SMTPAuth = true;
		$mail->IsHTML(true);
		$mail->Username = "info@sqs-serwis.pl"; /* login do skrzynki email często adres*/
		$mail->Password = "MiChu121"; /* Hasło do poczty */
		$mail->setFrom("info@sqs-serwis.pl", 'SQS Serwis elektroniczny'); /* adres e-mail i nazwa nadawcy */
		$mail->AddAddress($_POST["email"]); /* adres lub adresy odbiorców */
		$mail->Subject = "Potwierdzenie wiadomości z formularza";/* Tytuł wiadomości */
		
		$message = 'Twoja wiadomość wysłana do <a href="sqs-serwis.pl">SQS Serwis elektroniczny</a>:<br>';
		
		if(!empty($_POST["subject"])){
			$subject = $_POST["subject"];
		} else {
			$subject = '- brak';
		}
		$message .= 'Temat: ' . $subject . '<br><br>';
		$message .= $_POST['message']; 
		$mail->Body = $message;
		
		
		if(!$mail->Send()){
			$response = ['error' => ['msg' => 'Błąd wysyłania potwierdzenia wiadomości.', 'code' => 9]];
			echo json_encode($response, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
			return;		
		} else {
			$response = ['data' => 'OK'];
			echo json_encode($response, JSON_FORCE_OBJECT);
			return;
		}
	}
}


function error(){
	$response = ['error' => ['msg' => 'Nieprawidłowy parametr.',	'code' => 0]];
	echo json_encode($response, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	return;		
}

?>

