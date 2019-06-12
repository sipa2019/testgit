<?php
Abstract Class Db_Base {

	protected $registry;
	const DATA_STACK_ERROR = "DATA_STACK_ERROR";
	const DATA_STACK_SUCCESS = "DATA_STACK_SUCCESS";	
	const DATA_STACK_ERROR_RELATION = "DATA_STACK_RELATION";	

	function __construct($registry) {
		$this->registry = $registry;
		$this->conn = $this->registry['mysqli'];
		$this->_image = $this->registry['image'];	
		$this->_sessvar = $this->registry['sessvar'];			
	}	
	
	/*
	* Get record by id
	*
	* @param query
	*
	* @return  array
	*/
    public function fetchRow( $select=null ) {

		$row = array();	
		if ($select){
            $result = $this->conn->query($select);
            if ($result->num_rows>0) {
                $row = $result->fetch_object();
			}
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
	//$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
		$records = array();
        
        if ($select){
           // $result	=	mysqli_query($mysqli, $select);
		   $result = $this->conn->query($select);
		}
		if ($result->num_rows>0) {
            while ($row = $result->fetch_object()){
				$records[] = $row;
            }        
        }
        return $records;		
    }
	
	/*
	* Get records
	*
	* @param query
	*
	* @return  array - key Id
	*/
    public function findAll( $select ) {	
    
		$records = array();
        $result = $this->conn->query($select);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_object()){ 
                $records[$row->id] =$row;
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
	* Insert record
	*
	* @param array data
	* @param string nameDB
	*
	* @return  string result
	*/	
    public function  insertTranslation( $data, $nameDB = null,  $nameDB_translation = null, $field_foreign_key = null) {
		$nameDB = (!$nameDB) ? $this->_nameDB : $nameDB;
		$nameDB_translation = (!$nameDB_translation) ? $this->_nameDB_translation : $nameDB_translation;
		//var_dump($nameDB);
		//var_dump($nameDB_translation);
		//var_dump($field_foreign_key);
		return $this->insertRowTranslation($data, $nameDB, $nameDB_translation,$field_foreign_key );	
    }	

	/*
	* Insert record
	*
	* @param array data
	* @param string nameDB
	*
	* @return  string result
	*/	
    public function insertRowTranslation ( $data, $nameDB, $nameDB_Translation, $field_foreign_key ) {

		$stack = self::DATA_STACK_SUCCESS;
		$row = $this->getFieldsDbTable($nameDB);
		if (!$row) {
			$stack = self::DATA_STACK_ERROR;			
		}
		$query  = "INSERT INTO `".$nameDB."` (";
		$query .= $this->scopePartQueryInsert ($row, $data, $part = "field");		
		$query .= " ) VALUES ( ";
		$query .= $this->scopePartQueryInsert ($row, $data, $part = "data");			
		$query .= ")";

        $result = $this->conn->query($query);
		        
		if (!$result){

			$stack = self::DATA_STACK_ERROR;	
		}

		$data[$field_foreign_key]=$this->conn->insert_id;;

		
		 $row = $this->getFieldsDbTable($nameDB_Translation);

		if (!$row) {
			$stack = self::DATA_STACK_ERROR;			
		}
		$query  = "INSERT INTO `".$nameDB_Translation."` (";
		$query .= $this->scopePartQueryInsert ($row, $data, $part = "field");		
		$query .= " ) VALUES ( ";
		$query .= $this->scopePartQueryInsert ($row, $data, $part = "data");			
		$query .= ")";
//var_dump('111111111',$query);
		$result = $this->conn->query($query);        
		if (!$result){

			$stack = self::DATA_STACK_ERROR;	
		}
		
		$data['lang'] == 'ru' ? $data['lang'] = 'en' : $data['lang'] = 'ru';
		
		$query  = "INSERT INTO `".$nameDB_Translation."` (";
		$query .= $this->scopePartQueryInsert ($row, $data, $part = "field");		
		$query .= " ) VALUES ( ";
		$query .= $this->scopePartQueryInsert ($row, $data, $part = "data");			
		$query .= ")";
//var_dump('22222222'.$query);
		$result = $this->conn->query($query);        
		if (!$result){

			$stack = self::DATA_STACK_ERROR;	
		}
		
		
		return $stack;		
    }	
	/*
	* Update record
	*
	* @param array data
	* @param string nameDB
	*
	* @return  string result
	*/	
    public function update ( $data, $nameDB = null ) {
		var_dump($this->_nameDB);
		$nameDB = (!$nameDB) ? $this->_nameDB : $nameDB;
		return $this->updateRow($data, $nameDB);	
    }	
	
	/*
	* Update record
	*
	* @param array data
	* @param string nameDB
	*
	* @return  string result
	*/	
    public function updateRow ( $data, $nameDB ) {	
	//$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
		$stack = self::DATA_STACK_SUCCESS;		
		$row = $this->getFieldsDbTable($nameDB);
		$query  = "UPDATE `".$nameDB."` SET ";
		$query .= $this->scopePartQueryUpdate ($row, $data);		
		$query .= " WHERE id = '".$data['id']."'";

         //$result	=	mysqli_query($mysqli, $query); 
		 $result = $this->conn->query($query);
		if (!$result){
			return $stack = self::DATA_STACK_ERROR;	
		}
		return $stack;
    }	
	
	/*
	* Delete all record
	*
	* @return  string result
	*/
    public function truncate () {
	
		$stack = self::DATA_STACK_SUCCESS;			
		$query = "DELETE FROM `".$this->_nameDB."`";
        $result = $this->conn->query($query);   
	
		if (!$result){
			$stack = self::DATA_STACK_ERROR;			
		}
		return $stack;
    }		
	/*
	* Delete record
	*
	* @param int Id
	* @param string nameDB
	*
	* @return  string result
	*/
    public function delete ( $cid ) {
	
		$stack = self::DATA_STACK_SUCCESS;			
		$query = "DELETE FROM `".$this->_nameDB."` WHERE id='".$cid."'";
        $result = $this->conn->query($query);   
		if (!$result){
			$stack = self::DATA_STACK_ERROR;			
		}
		return $stack;
    }	
	
	/*
	* Update field active
	*
	* @param int Id
	* @param int current status
	* @param string nameDB
	*
	* @return  string result
	*/
    public function show ( $cid, $current ) {
	
		$is_active = ('0'==$current) ? '1' : '0';
		$stack = self::DATA_STACK_SUCCESS;			
		$query = "UPDATE `".$this->_nameDB."` SET
				published	= '$is_active'
				WHERE id = '".$cid."'";	
		$result = $this->conn->query($query);
		
		if (!$result){
			$stack = self::DATA_STACK_ERROR;			
		}	
      return $stack;		
    }	

/*
	* Update field active
	*
	* @param int Id
	* @param int current status
	* @param string nameDB
	*
	* @return  string result
	*/
    public function showPage ( $cid, $current, $is_active ) {

		$stack = self::DATA_STACK_SUCCESS;			
		$query = "UPDATE `".$this->_nameDB."` SET
				visible	= '$is_active'
				WHERE id_razdel = '".$cid."'";
					
		$result = $this->conn->query($query);
		
		if (!$result){
			$stack = self::DATA_STACK_ERROR;			
		}
			
      return $stack;		
    }	


	/*
	* Update field top
	*
	* @param int Id
	* @param int current status
	* @param string nameDB
	*
	* @return  string result
	*/
    public function top ( $cid, $current ) {

		$is_top = ('0'==$current) ? '1' : '0';
		$stack = self::DATA_STACK_SUCCESS;			
		$query = "UPDATE `".$this->_nameDB."` SET
				is_top	= '$is_top'
				WHERE id = '".$cid."'";	
		$result = $this->conn->query($query);
		
		if (!$result){
			$stack = self::DATA_STACK_ERROR;			
		}	
      return $stack;		
    }	
	
	/*
	* Delete relation records field 
	*
	* @param int Id / array Ids
	* @param string name field
	* @param string nameDB
	*
	* @return  string result
	*/	
    public function deleteRel ( $cid, $field, $nameDB = null) {
		$nameDB = $nameDB ? $nameDB : $this->_nameDB; 
		$cids = !is_array($cid) ? array($cid) : $cid;
		$stack = self::DATA_STACK_SUCCESS;			
		$query = "DELETE FROM `".$nameDB."` WHERE ".$field." IN (".implode(",", $cids).")";
	//var_dump($query);
		$result = $this->conn->query($query);
		
		if ($result == FALSE){
			$stack = self::DATA_STACK_ERROR;			
		}
		return $stack;
    }

/*
	* Delete One record field 
	*
	* @param int Id / array Ids
	* @param string name field
	* @param string nameDB
	*
	* @return  string result
	*/	
    public function deleteRelOneRecord ( $cid, $field, $nameDB = null) {
		$nameDB = $nameDB ? $nameDB : $this->_nameDB; 
		$stack = self::DATA_STACK_SUCCESS;			
		$query = "DELETE FROM `".$nameDB."` WHERE ".$field." = ".$cid;

		$result = $this->conn->query($query);
	
		if ($result == FALSE){
			$stack = self::DATA_STACK_ERROR;			
		}
		
		return $stack;
    }



	/*
	* Populate array from record
	*
	* @param int Id / null
	* @param string nameDB
	*
	* @return  array
	*/		
    public function populate( $query ) {	

        $row=array();
		if ($query) {
			$result = $this->conn->query($query);
			if ($result) {
				$finfo = $result->fetch_fields();        
				if ($result->num_rows==0) {
					foreach ($finfo as $val) {
						$row[$val->name] = '';                    
					}
				} else {
					$data = $result->fetch_object();
					foreach($data as $key => $value) {
						//if ('html'==$key) {
							//$row[$key] = htmlentities($value);   				
						//} else {					
							$row[$key] = $value;
						//}
					}
				}
			}
        }
		return $row;		
	}	
	
	
	
	/*
	* Populate array from $_POST
	*
	* @param string nameDB
	*
	* @return  array
	*/		
    public function toArray( $query ) {	

        $finfo = $data = array();

        if ($result = $this->conn->query( $query )) {
            $finfo = $result->fetch_fields();
        }

        foreach ($finfo as $fields) {
			if ('image' == $fields->name){
				if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])){
					$data['image'] = $_FILES['image'];
				}			
			} else {
				$data[$fields->name] = isset($_POST[$fields->name]) ? $_POST[$fields->name] : '';
			}        
        }
	
		return $data;
	}	

	/*
	* GET records by paginate
	*
	* @param string query with total count
	* @param string query 
	* @param string sort 	
	* @param int page 		
	* @param int count records by page 			
	*
	* @return  string result
	*/		
    public function paginate ($select=null, $sort='', $list=1, $listPage=5) {	

$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if (!$mysqli) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//echo "Соединение с MySQL установлено!" . PHP_EOL;
//echo "Информация о сервере: " . mysqli_get_host_info($mysqli) . PHP_EOL;
	
		if ($select){
			$paginator	= array();
			$records	= array();

			$result	=	mysqli_query($mysqli, $select);
           
			if ($result){
				if ($result->num_rows !=0){

                    $kol_count = $result->fetch_object();

					$pageCount = ceil($kol_count->total_record/$listPage);
					$pagesInRange = array();
					for ($x=1; $x<$pageCount+1; $x++) $pagesInRange[]=$x;	
	
					$pagecurrent	= $list;
					$previous	 	= ($pagecurrent>1) ? ($pagecurrent-1) : 0;
					$next 		= ($pagecurrent<$pageCount) ? ($pagecurrent+1) : 0;
					$limit 		= ($pagecurrent-1)*$listPage.','.$listPage;	
	
					$paginator = array(
						'pageCount' => $pageCount,
						'previous' => $previous,				
						'next' => $next,				
						'pagecurrent' => $pagecurrent,								
						'pagesInRange' => $pagesInRange,								
						'limit' => $limit,								
					);

					$select .= $sort." LIMIT ".$paginator['limit'];

					$records = $this->fetchAll( $select ); 
					return array(	'paginator'=> $paginator,
								'records'=>$records
								);				
				}								
			}
		}
		return false;		
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
	* create string of part Query for Update
	*
	* @param array field current table $row
	* @param array data $data
	* 
	* @return part query
	*/
	public function scopePartQueryUpdate ($row, $data){
	
		if (!$row || !$data) {
			return false;
		}
		$query = "";
		foreach ($row as $field):	
			if (isset($data[$field])) {
				$query .= $field."='".$data[$field]."',";				
			}
		endforeach;
		if ($query) {
			$query = substr($query, 0, -1);
		}
		return $query;
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
	
    /**
	* Get Relation key
     * @return string
     */
    public function getRelationKey()
    {
        if ($this->translationForeignKey) {
            $key = $this->translationForeignKey;
        } else {
            $key = $this->_nameDB."_id";
        }
        return $key;
    }	
	/*
	* GET translit field
	*
	* @param string 
	*
	* @return  string result
	*/	
	public function translitSlug($urlstr=null)
	{
		if ($urlstr){
			$translit = $this->encodingSymbolList();
			$urlstr = strtr($urlstr, $translit);		
			$urlstr = preg_replace('/[^A-Za-z0-9_\-]/', '', $urlstr);		
		}
		return $urlstr;
	}
	
	/*
	* GET order sort
	*
	* @param array parameters of sort
	*
	* @return  string result
	*/	
    public function order($param) {		
		$sort = "";
		if (isset($param['sort'])) {
			$sort = " ORDER BY ".$param['sort'];
			$sort .= isset($param['by']) ? " ".$param['by'] : " DESC";
		}
		return $sort;
	}
	
	/**
     * @return array
     */
    private function selectWithCount ($select)
    {

		return implode(" SELECT COUNT(*) AS total_record, ", 
				explode("SELECT", 
					str_ireplace("select", "SELECT", $select), 2)
		);			
	}
	

	/**
     * @return array
     */
    private function encodingSymbolList ()
    {
        return array(
		"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
		"Е"=>"E","Ё"=>"YO","Ж"=>"ZH","З"=>"Z","И"=>"I",
		"Й"=>"J","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
		"О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
		"У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"C","Ч"=>"CH",
		"Ш"=>"SH","Щ"=>"SHH","Ъ"=>"","Ы"=>"Y","Ь"=>"",
		"Э"=>"E","Ю"=>"YU","Я"=>"YA",
		"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
		"е"=>"e","ё"=>"yo","ж"=>"zh","з"=>"z","и"=>"i",
		"й"=>"j","к"=>"k","л"=>"l","м"=>"m","н"=>"n",
		"о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
		"у"=>"u","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch",
		"ш"=>"sh","щ"=>"shh","ъ"=>"","ы"=>"y","ь"=>"",
		"э"=>"e","ю"=>"yu","я"=>"ya"," "=>"_","-"=>"",
		"Ā"=>"A","ā"=>"a",
		"Č"=>"CH","č"=>"ch",
		"Ē"=>"E","ē"=>"e",
		"Ģ"=>"G","ģ"=>"g",
		"Ī"=>"I","ī"=>"i",
		"Ķ"=>"K","ķ"=>"k",
		"Ļ"=>"L","ļ"=>"l",
		"Ņ"=>"N","ņ"=>"n",
		"Š"=>"SH","š"=>"sh",
		"Ū"=>"U","ū"=>"u",
		"Ž"=>"ZH","ž"=>"zh",
		);
    }
	
}
?>