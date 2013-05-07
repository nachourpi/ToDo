<?php
function security(){
	
	if(isset($_REQUEST['token'])){
			$users = new UsersManager();
			$users->loginByToken($_REQUEST['token']);
	}
	if(!isset($_SESSION['idUser']) || !is_numeric($_SESSION['idUser']) || $_SESSION['idUser']==0)
	{
		
		header("Location:login.php");
		
	}
	
	
}

 ?>