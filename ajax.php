<?php

	$name=$_POST['name'];
	$email=$_POST['email'];
	$comments=$_POST['comments'];
	
	$message="";
	
	$message .=strip_tags($comments);

	$subject_line="Formless Contact Test";
	$file_message=$message;
	$headers="From: ".$name." <".$email.">";

	$errorcount = 0;
	$error = "";
	if ($name=="") {
		$errorcount = $errorcount+1;
		$error .="Name is Required \n";
	}
	if ($email=="") {
		$errorcount = $errorcount+1;
		$error .="Email is Required \n";
	}
	if ($errorcount > 0) {
		echo json_encode(nl2br($error));
		
	} else {
		mail ("contactforms@digitalbridge.com.au",$subject_line,$file_message,$headers);
	}		

?>