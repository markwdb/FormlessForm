<?php

require_once("class/email.class.php");
//require_once("class/sqlQuery.class.php");
 
class ContactUsForm {
	
	var $submitted	 = false;
	var $error_message = null;
	var $contact_us	= null;

	// Form configuration
	var $client_name		= "FormlessForm";
	var $subject_line	   = "";
	var $from_email		 = "noreply@digitalbridge.com.au";
	var $from_name		  = "";
	//var $recipient_email	= "contactforms@digitalbridge.com.au";
	var $recipient_email	= "markw@digitalbridge.com.au";
	var $redirect		   = "#";
	
	// Constant error messages
	var $captcha_error_message = "Incorrect Code Entered";
	
	
	// SERVER info
	var $request_uri;
	var $ip_address;
	
	
	function ContactUsForm() {
		
		$this->contact_us = new ContactUs();
		
		if ($_POST['submitted'] == "submitted") {
			// Init
			$this->subject_line = "Enquiry from {$this->client_name} Website";
			$this->from_name = $this->client_name;
			$this->ip_address  = $this->GetIP();
			$this->request_uri = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			$this->contact_us->fromData($_POST);

			// Captcha
			include("securimage/securimage.php");
			$img = new Securimage();
			$valid = $img->check($_POST['captcha_code']);

			// Validation, error checking
			if ($valid == true) {
				$this->submitted = true;
			} else {
				$this->error_message = $this->captcha_error_message;
			}
		}

		if ($this->submitted) {
			$this->sendEmail();
			//$this->toDb();
		}
	}
	
	
	function sendEmail() {
		$message = $this->generateMessage();
		if (trim($message) == "")
			return;
		$email = new Email($this->subject_line, $message, $this->from_email, $this->from_name);
		//$email->addRecipient($this->contact_us->email_address);
        //$email->addRecipient("contactforms@digitalbridge.com.au");	
		$email->addRecipient($this->recipient_email);
		$result = $email->send();
	}
	

	function generateMessage() {
		$message = "";
		$ignore_names = array("recipient_email",
							  "from_email",
							  "from_name",
							  "subject",
							  "redirect",
							  "submitted"
							 );
		foreach ($this->contact_us as $key => $value) {
			if (in_array($key, $ignore_names) || !isset($value))
				continue;
			if (strtolower($key) <> "submit") {
				if ($key == $value) {
					//$value = "CHECKED";
				}
				$key = str_replace("_"," ",$key);
				$key = ucwords(strtolower($key));	 
				$message .= "{$key}: ".stripslashes($value)."\n";
			}
		}
		
		return $message;
	}
	

	function GetIP() {
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
		else
			$ip = "unknown";
		return $ip;
	}
	

/*
	function toDb() {
		$query = "INSERT INTO `contact_us` 
				  SET first_name	= '" . $this->contact_us->first_name. "', 
					  last_name	 = '" . $this->contact_us->last_name . "',
					  email_address = '" . $this->contact_us->email_address . "',
					  website	   = '" . $this->contact_us->website . "',
					  phone		 = '" . $this->contact_us->phone . "',
					  comments	  = '" . $this->contact_us->comments . "',
					  request_uri   = '" . $this->request_uri . "',
					  ip_address	= '" . $this->ip_address . "' ";
		$sql_query = new SqlQuery($query);
	} 
*/
	
}


class ContactUs {

	var $first_name;
	var $last_name;
	var $email_address;
	var $website;
	var $phone;
	var $comments;


	function fromData($data) {
		foreach ($data as $key => $value)
			$this->{$key} = $value;
	}
	
}
