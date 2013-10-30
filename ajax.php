<?php
ini_set('display_errors',true);

require_once("class/contactUsForm.class.php");
require_once("class/formlessAjax.class.php");

$action = $_GET['action'];
$ajax = new FormlessAjax();
switch ($action) {
    case "sendForm":
    	$name=$_GET['name'];
    	$email=(int)$_GET['email'];
    	$comments=(int)$_GET['comments'];
        echo $ajax->sendForm($name,$email,$comments);     
        break;
  
}
