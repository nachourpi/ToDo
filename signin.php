<?php

require_once 'lib/base.inc.php';

$users = new UsersManager();

switch($_REQUEST['action']){

	case "login":
	
		
		
		if($_REQUEST['new']==1){
			$users->create($_REQUEST['username'],$_REQUEST['password']);
		
		}
		
		
		$login = $users->login($_REQUEST['username'],$_REQUEST['password']);
		echo json_encode(array("login"=>$login,"MSG"=>$login?"LogIn successful":"LogIn failed."));
		
		break;
	case "logout":
		$logout=$users->logout();
		echo json_encode(array("login"=>$logout,'MSG'=>$logout?"LogOut successful":"LogOut failed."));
		
		break;

}



?>