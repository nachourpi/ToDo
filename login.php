<?php

require_once 'lib/base.inc.php';

$users = new UsersManager();

switch($_REQUEST['action']){

	case "login":
	
		
		
		if($_REQUEST['new']==1){
			$users->create($_REQUEST['username'],$_REQUEST['password']);
		
		}
		
		
		
		if($users->login($_REQUEST['username'],$_REQUEST['password'])){
			
			header("Location:index.php");
		}
		$error_login=true;
		
		break;
	case "logout":
		
		$users->logout();
		
		break;

}

include('login.tpl.php');


?>