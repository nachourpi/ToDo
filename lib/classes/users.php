<?php


class UsersManager
{
    var $conn;
    
    function __construct(){
        $this->conn = getDbConnection();
    }

    
    public function getById($idItem){
    		$sql = "SELECT * FROM items WHERE idItem='$idItem'";
		
	        	
	        $result = $this->conn->query($sql);
	        
			$obj = array();
	        
			if($row = $result->fetch_object()) {
				$obj=$row;
			}
		        
			return $obj;
	}
	public function create($username,$password){
        
        
        $sql = "INSERT INTO users (username,password) VALUES('$username','$password') ";
		$result = $this->conn->query($sql);
        
		$id = $this->conn->insert_id;
		if($id>0){
			$this->login($username,$password);
		}
		
        return $id;
    }
    public function login($username,$password){
        
        
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        
		$result = $this->conn->query($sql);
        
		if($result->num_rows > 0 ){
			if($row = $result->fetch_object()) {
				$obj=$row;
			}
			
			$_SESSION['idUser'] = $obj->idUser;
			$_SESSION['username'] = $obj->username;
			
			
			$token = hash("md5",$_SESSION['username']);
			
			$sql = "UPDATE users SET token='$token' WHERE idUser='".$_SESSION['idUser']."'";
        
			$result = $this->conn->query($sql);
			
			return $token;
		}
		
        return false;
    }
	public function loginByToken($token){
        
        
        $sql = "SELECT * FROM users WHERE token='$token' ";
        
		$result = $this->conn->query($sql);
        
		if($result->num_rows > 0 ){
			if($row = $result->fetch_object()) {
				$obj=$row;
			}
			
			$_SESSION['idUser'] = $obj->idUser;
			$_SESSION['username'] = $obj->username;
			
			
			return $token;
		}
		
        return false;
    }
	public function logout(){
		
		$_SESSION['idUser'] = '';
		$_SESSION['username'] = '';
        
		
		
        return session_destroy();
		
	}

}


?>