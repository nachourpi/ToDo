<?

function getDbConnection(){

	    $db_hostname = "localhost";
		$db_database = "lucilita_todo";
		$db_username = "lucilita_todo";
		$db_password = "11dejulio";
		
	
		$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if (mysqli_connect_error()) {
			die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
		
		$conn->select_db($db_database);
		//$conn->query("SET NAMES 'utf8'");
			
		return $conn; 

}

?>