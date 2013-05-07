<?php
require_once 'lib/base.inc.php';
security();

$items = new ItemsManager($_REQUEST['idList']);

switch($_REQUEST['action']){
	case "create":
		
		$items->create($_REQUEST['title'],$_REQUEST['priority'],$_REQUEST['dueDate']);
		
		
		break;
	case "modify":
		
		$items->modify($_REQUEST['idItem'],$_REQUEST['title'],$_REQUEST['priority'],$_REQUEST['dueDate'],$_REQUEST['status']);
		
		
		
		break;
	case "delete":
		
		$items->delete($_REQUEST['idItem']);
		
		
		
		break;
}


?>