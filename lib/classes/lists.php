<?php

define('ORDERBY1','dueDate');
define('ORDERBY2','priority');


class ListsManager
{
    var $conn;
	var $idUser;
    var $orderBy;
	var $order;
	
    function __construct($idUser){
        $this->conn = getDbConnection();
		$this->idUser = $idUser;
		$this->orderBy = ORDERBY1;
		$this->order = 'DESC';
    }
	public function setOrderBy($orderBy){
		$this->orderBy=$orderBy;
	}
	public function setOrder($order){
		$this->order = $order;
	}
    public function getByUser(){
    
        $sql = "SELECT * FROM lists WHERE idUser='".$this->idUser. "' ";
		$result = $this->conn->query($sql);
        
        $objs = array();
        
        while ($row = $result->fetch_object()) {
                
				$itemsManager = new ItemsManager($row->idList);
				$itemsManager->setOrder($this->order);
				$itemsManager->setOrderBy($this->orderBy);
				$row->items = $itemsManager->getByList();
				$objs[]=$row;
				
        }
        
		return $objs;

    }
    public function getById($idList){
    		$sql = "SELECT * FROM lists WHERE idList='$idList'";
		
	        	
	        $result = $this->conn->query($sql);
	        
			$obj = array();
	        
			if($row = $result->fetch_object()) {
				$itemsManager = new ItemsManager($row->idList);
				$itemsManager->setOrder($this->order);
				$itemsManager->setOrder($this->orderBy);
				$row->items = $itemsManager->getByList();
				
				$obj=$row;
				
			}
		        
			return $obj;
	}
	
	public function create($title){
        
        
        $sql = "INSERT INTO lists (idUser,title,date) VALUES('".$this->idUser."','$title',NOW()) ";
		$result = $this->conn->query($sql);
        
        return $this->conn->insert_id;
    }
    public function modify($idList,$title){
        
        
        $sql = "UPDATE lists SET title='$title',date=NOW() WHERE idList='$idList'";
        
		$result = $this->conn->query($sql);
        
        return $result;
    }
	public function delete($idList){
		
		$itemsManager = new ItemsManager($idList);
		if(!$itemsManager->deleteByList())
			return false;
		
		$sql = "DELETE FROM lists WHERE idList='$idList'";
		
		$result = $this->conn->query($sql);
        
        return $result;
		
	}
}


?>