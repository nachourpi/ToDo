<?php
require_once 'lib/base.inc.php';
security();

$lists = new ListsManager($_SESSION['idUser']);

switch($_REQUEST['action']){
	case "create":
		
		$lists->create($_REQUEST['title']);
		
		
		break;
	case "modify":
		
		$lists->modify($_REQUEST['idList'],$_REQUEST['title']);
		
		
		
		break;
	case "delete":
		
		$lists->delete($_REQUEST['idList']);
		
		
		
		break;
	case "list":
		
		if(isset($_REQUEST['orderBy']))
			$lists->setOrderBy(($_REQUEST['orderBy']==1)?"dueDate":"priority");
		if(isset($_REQUEST['order']))
			$lists->setOrder(($_REQUEST['order']==1)?"ASC":"DESC");

		echo json_encode($lists->getByUser());
		
		
		break;
}



?>