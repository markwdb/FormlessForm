<?php

class Email {

	var $recipients;
	var $message;
	var $subject_line;
	var $from_name;
	var $from_email;

	function Email($subject_line, $message, $from_email, $from_name = "") {
		$this->subject_line = $subject_line;
		$this->message	  = $message;
		$this->from_email   = $from_email;
		$this->from_name	= $from_name;
	}
	
	function setRecipients($recipients) {
		$this->recipients = array();
		$this->recipients = $recipients;
	}

	function addRecipient($recipient){
		$this->recipients[] = $recipient;
	}
	
	function send() {		
		if (sizeof($this->recipients) > 0 AND isset($this->message)) {
			if ($this->from_name == "")
				$header = "From:" . $this->from_email;
			else
				$header = "From:" . $this->from_name . "<" . $this->from_email . ">";		 
 
			foreach ($this->recipients as $recipient) {
/*				 print_r($recipient);print_r($this->message); die; */
				$result = mail($recipient, $this->subject_line, $this->message, $header);
				if ($result === FALSE) {
					return FALSE;
				}
			}
			return TRUE;
		} else {
			return FALSE;
		}	   
	}
}

?>