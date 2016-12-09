<?php
	if (!isset($_REQUEST['cmd'])) {
		echo '{"result": 0, "message": "Command not entered"}';
	}
	$command = $_REQUEST['cmd'];
	switch($command) {
		case 1:
		addUser();
		break;

		case 2:
		logUser();
		break;

		case 3:
		sendMsg();
		break;

		default:
		echo "wrong cmd";
		break;
	}

function addUser() {
	if (($_REQUEST['username']=="") || ($_REQUEST['firstname']=="") || ($_REQUEST['lastname']=="") || ($_REQUEST['email']=="")
		|| ($_REQUEST['password']=="") || ($_REQUEST['phone']=="") || ($_REQUEST['organization']=="")) {
		echo '{"result":0, "message": "All user information required was not given"}';
		return;
	}
	
	include_once("users.php");
	$obj = new users();
	$username = $_REQUEST['username'];
	$firstname = $_REQUEST['firstname'];
	$lastname = $_REQUEST['lastname'];
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	$phone= $_REQUEST['phone'];
	$organization = $_REQUEST['organization'];
	
	$a = $obj->newUser($username,$firstname,$lastname,$email,$password,$phone,$organization);

	if (!$a) {
		echo '{"result":0 ,"message": "Could not add User"}';
	}
	
	else {
		$sms=$obj->sendsms($phone);
	 echo '{"result":1, "message": "User sucessfully added"}';	
	}
	
}

function logUser(){
	if (($_REQUEST['username']=="") || ($_REQUEST['password']=="")) {
		echo '{"result":0, "message": "All user information required was not given"}';
		return;
	}
	
	include_once("users.php");
	$obj = new users();
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	
	$result = $obj->getUser($username,$password);

	if ($result==false) {
		echo '{"result":0 ,"message": "Could not log User"}';
	}
	
	else {

	 echo '{"result":1, "message": "User sucessfully logged in"}';	
	}
}

function sendMsg() {
	if (($_REQUEST['date']=="") || ($_REQUEST['title']=="") || ($_REQUEST['message']=="")) {
		echo '{"result":0, "message": "All required fields were not filled"}';
		return;
	}
	
	include_once("users.php");
	$obj = new users();
	$date = $_REQUEST['date'];
	$title = $_REQUEST['title'];
	$message = $_REQUEST['message'];

	
	$a = $obj->newMsg($date,$title,$message);

	if (!$a) {
		echo '{"result":0 ,"message": "Could not send Message"}';
	}
	
	else {
	 echo '{"result":1, "message": "Message Sent"}';	
	}
	
}


?>