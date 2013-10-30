<?php
class formlessAjax extends Ajax{
	
	function sendForm($name,$email,$comments){
		$email = ContactUsForm::ContactUsAjax($name,$email,$comments);
		print_r($email);
		ContactUsForm::generateMessage($email);		
		//ContactUsForm::sendEmail($email);
	//	return json_encode($results);
	}

}
class Ajax{
	
	function objectToOptions($objects,$key,$value,$empty_label){
		$options=array();
		$options[]=array("value"=>"","text"=>$empty_label);
		foreach ($objects as $object){
			//$options[$object->{$key}]=$object->{$value};
			//$options[]=array($object->{$key}=>$object->{$value});
			//$options[]=array($key=>$object->{$key},$value=>$object->{$value});
			//$options[]=array($object->{$key},$object->{$value});
			$options[]=array("value"=>$object->{$key},"text"=>$object->{$value});
		}
		return $options;
	}
}



?>