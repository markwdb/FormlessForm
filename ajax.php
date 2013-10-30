<?php
ini_set('display_errors',false);
include("inc/auth.php");
if (@$login->is_login()==false){
	header("Location: login.php");
	die;
}
require_once("class/sPlanAjax.class.php");
$action = $_GET['action'];
$ajax = new SPlanAjax();
switch ($action) {
    case "nameSearch":
    	$name_search=$_GET['name_search'];
    	$id_client=(int)$_GET['id_client'];
    	$id_project=(int)$_GET['id_project'];
        echo $ajax->nameSearch($name_search,$id_client,$id_project);     
        break;
    case "addUserWorkgroup":
    	$id_user=$_GET['id_user'];
    	$id_workgroup=$_GET['id_workgroup'];
        echo $ajax->addUserWorkgroup($id_user,$id_workgroup);     
        break;
   case "actionToggle":
    	$id_user=(int)$_GET['id_user'];
    	$id_project=(int)$_GET['id_project'];
    	$id_action=(int)$_GET['id_action'];
    	$action_type=$_GET['action_type'];
    	$action_value=$_GET['action_value'];
		echo $ajax->actionToggle($id_user,$id_project,$id_action,$action_type,$action_value);	
		break;   
   case "getElements":
    	$id_type=(int)$_GET['id_type'];
    	echo $ajax->getDiagnosticElements($id_type);	
		break; 		  
}
