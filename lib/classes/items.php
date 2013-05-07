<?php

define('ACTIVE_ITEM',1);

class ItemsManager
{
    var $conn;
    var $idList;
	var $oderBy;
	var $order;
	
    function __construct($idList){
        $this->conn = getDbConnection();
		$this->idList = $idList;
    }
	public function setOrderBy($orderBy){
		$this->orderBy=$orderBy;
	}
	public function setOrder($order){
		$this->order = $order;
	}
    public function getByList(){
    
        $sql = "SELECT * FROM items WHERE idList='".$this->idList."' ORDER BY ".$this->orderBy." ".$this->order;
		$result = $this->conn->query($sql);
        
		//echo $sql;
        $objs = array();
        
        while ($row = $result->fetch_object()) {
                $objs[]=$row;
        }
        
		return $objs;

    }
    	public function getById($idItem){
    		$sql = "SELECT * FROM items WHERE idItem='$idItem' ORDER BY ".$this->orderBy." ".$this->order;
		
	        	
	        $result = $this->conn->query($sql);
	        
			$obj = array();
	        
			if($row = $result->fetch_object()) {
				$obj=$row;
			}
		        
			return $obj;
	}
	public function create($title,$priority,$dueDate){
        
        
        $sql = "INSERT INTO items (idList,title,priority,dueDate,status) VALUES('".$this->idList."','$title','$priority','$dueDate','".ACTIVE_ITEM."') ";
		$result = $this->conn->query($sql);
        
        return $this->conn->insert_id;
    }
    public function modify($idItem,$title,$priority,$dueDate,$status){
        
        
        $sql = "UPDATE items SET title='$title',priority='$priority',dueDate='$dueDate',status='$status' WHERE idItem='$idItem'";
        
		$result = $this->conn->query($sql);
        
        return $result;
    }
	public function delete($idItem){
		
		$sql = "DELETE FROM items WHERE idItem='$idItem'";
		
		$result = $this->conn->query($sql);
        
        return $result;
		
	}
	
	public function deleteByList(){
		$sql = "DELETE FROM items WHERE idList='".$this->idList."'";
		
		$result = $this->conn->query($sql);
        
        return $result;
	}
}


?>