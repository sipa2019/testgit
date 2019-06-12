<?php
Abstract Class Db_Base {


    /*
    * Get record by $select
    *
    * @param select
    *
    * @return  array
    */
    public function baseConnect(){
        $link = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        return $link;
    }


    public function fetchRow( $select=null ) {

        $mysqli = $this->baseConnect();

        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $row = array();

        if ($select){
            $result	=	mysqli_query($mysqli, $select);
        }

        if ($result->num_rows>0) {
            $row = $result->fetch_object();
        }

        return $row;

    }

    /*
    * Get records
    *
    * @param query
    *
    * @return  array - key number
    */
    public function fetchAll( $select ) {
        $mysqli = $this->baseConnect();
        $records = array();

        if ($select){
            $result	=	mysqli_query($mysqli, $select);
        }
        if ($result->num_rows>0) {
            while ($row = $result->fetch_object()){
                $records[] = $row;
            }
        }
        return $records;
    }



/*
	* Insert record
	*
	* @param array data
	* @param string nameDB
	*
	* @return  string result
	*/	
    public function insert ( $data, $nameDB = null ) {
//var_dump($data);
		$nameDB = (!$nameDB) ? $this->_nameDB : $nameDB;
		//var_dump($nameDB);
		return $this->insertRow($data, $nameDB);	
    }	


/*
	* Insert record
	*
	* @param array data
	* @param string nameDB
	*
	* @return  string result
	*/	
    public function insertRow ( $data, $nameDB ) {
		
		$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
		$stack 	= self::DATA_STACK_SUCCESS;
		$row 	= $this->getFieldsDbTable($nameDB);
		//var_dump($row);
		if (!$row) {
			$stack = self::DATA_STACK_ERROR;			
		}
		$query  = "INSERT INTO `".$nameDB."` (";
		$query .= $this->scopePartQueryInsert ($row, $data, $part = "field");		
		$query .= " ) VALUES ( ";
		$query .= $this->scopePartQueryInsert ($row, $data, $part = "data");			
		$query .= ")";
		//var_dump($query);
		$result	=	mysqli_query($mysqli, $query);
		// $result = $this->conn->query($query);
		// var_dump($result);
		if (!$result){

			$stack = self::DATA_STACK_ERROR;	
		}
		return $stack;		
    }
    
    
    
    /*
	* GET fields by DB table
	*
	* @param string name dbTable
	*
	* @return  array fields
	*/	
	public function getFieldsDbTable($nameDB )
	{
		$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);	
			
        $query = "SELECT * FROM `".$nameDB."`";		
        $result = mysqli_query($mysqli, $query);
        if (!$result) {
			return array();
		}
		$finfo = $result->fetch_fields();        
		foreach ($finfo as $val) {
			$row[] = $val->name;                    
		}
		return $row;
	}

	
	
	/*
	* create string of part Query for Insert
	*
	* @param array field current table $row
	* @param array data $data
	* @param string part of query (field / data)
	* 
	* @return part query
	*/
	public function scopePartQueryInsert ($row, $data, $part = "field"){
	
		if (!$row || !$data) {
			return false;
		}
		$query ="";
		foreach ($row as $field):	
			if (isset($data[$field])) {
				if ("field"==$part) {
					$query .= $field.",";
				} else {
					$query .= "'".$data[$field]."',";			
				}
			}
		endforeach;
		
		if ($query) {
			$query = substr($query, 0, -1);
		}
		return $query;
	}
    
    
    
    
    
    
    
    	

}
?>