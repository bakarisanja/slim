<?php

function returnError($errorMessage = '')
{
	$errorArray = array(
		'error'			=> true,
		'error_message' => $errorMessage,
		'message_date' 	=> date('m/d/Y H:i:s'),
		'post'			=> $_POST
		);
	$encodedJSN = json_encode($errorArray);
	header('Content-Type: application/json; charset=utf-8');
	echo $encodedJSN;
	exit();
}

//date validation...
function CheckIsAValidDate($date_of_birth = '')
{
	return (bool)strtotime($date_of_birth);
}

//checking a user years range
function CheckUserYears($date_of_birth = '')
{
	$date_of_birth = strtotime($date_of_birth);
    $date_of_birth = gmdate("Y-m-d", $date_of_birth);
    $current_year = gmdate("Y-m-d",$_SERVER['REQUEST_TIME']);
    $diference = $current_year - $date_of_birth;	
    if ($diference < 25 || $diference > 57) {
    	return false;
    }else{
    	return true;
    }
}

//success message
function SuccessMessage($username = '')
{
	$successArray = array(
		'error'        => false,
		'username'     => $username,
		'message_date' => date('m/d/Y H:i:s'),
		'post'         => $_POST
		);
	$encodedJSN = json_encode($successArray);
	header('Content-Type: application/json; charset=utf-8');
	echo $encodedJSN;
	exit();
}


//generate token function
function token($length)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
   	return substr(str_shuffle($characters), 0, $length);
}

//overvriteing password
function passAsterisk(){
	$asterisk = array();
	for($i=0; $i < strlen($_POST['password']); $i++){
		$asterisk[] = '*';
	}
	 $asterisk = implode('',$asterisk);
	return $asterisk;
}

//successlogin
function successLogin($username = '', $token = '', $asterisk = '')
{
	$loginArray = array(
		'error'        => false,
		'message_date' => date('m/d/Y H:i:s'),
		'username'     => $username,
		'password'     => $asterisk,
		'ip'           => $_SERVER['REMOTE_ADDR'],
		'token'        => $token
		);
	$encodedJSN = json_encode($loginArray);
	header('Content-Type: application/json; charset=utf-8');
	echo $encodedJSN;
	exit();
}