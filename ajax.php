<?php
ini_set('display_errors',true);
require_once("class/formlessAjax.class.php");

$action = $_GET['action'];
switch ($action) {
    case "sendForm":
		$message="";

    	$name=$_GET['name'];
    	$email=$_GET['email'];
    	$comments=$_GET['comments'];

		$message .=$comments;
		$subject_line="Test";
		$file_message=$message;
		$headers="From: ".$name." <".$email.">";

  
		mail ("markw@digitalbridge.com.au",$subject_line,$file_message,$headers);

        break;  
}
