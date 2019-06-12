<?php
/*
	Posts Class
*/
//require_once SITE_PATH . 'model'. DIRSEP .'News.php';

Class RcClass extends Db_Base {

    protected $_nameDB = 'ori_rc';
	
	/*
	* GET base SELECT 
	*
	* @param 
	*
	* @return  string 
	*/
    public function baseSelect ()
    {
		$select = "SELECT ".$this->_nameDB.".*
				FROM `".$this->_nameDB."` AS ".$this->_nameDB;
//var_dump($select);
		return $select;
	}
	

	
	/*
	* GET record by Id
	*
	* @param int Id
	*
	* @return  object record
	*/	
    public function findById ($id)
    {
		if (!$id) {
			return false;
		}
		$select = $this->baseSelect();
		$select 	.= " WHERE ".$this->_nameDB.".id =  '".$id."'";	
			
		return $this->fetchRow($select);		
    }


	
	/*
	* GET main Category records by paginators
	*
	* @param array parameters
	*
	* @return  object records
	*/	
    public function paginatorCat ( $param = null, $page = 1, $limit = 5, $lang ) {

		$select = $this->baseSelect();

		if(isset($_GET['section'])){
			$section=$_GET['section'];
			$select 	.= " WHERE ".$this->_nameDB.".lang = '".$lang."' AND ".$this->_nameDB.".section = '".$section."'";
		}else{
			$select 	.= " WHERE ".$this->_nameDB.".lang = '".$lang."'";	
		}
		$sort = $this->order($param);

        return parent::paginate( $select, $sort, $page, $limit);
	
	}
	
	
	
	/*
	* Populate array from record
	*
	* @param int Id / null
	*
	* @return  array
	*/	
    public function setPOST( $cid=null ) {	

		$query = $this->baseSelect();		
		$query .= " WHERE ".$this->_nameDB.".id = '".$cid."'";     

		return parent::populate($query);		
	}
	
	/*
	* Populate array from $_POST
	*
	* @param string nameDB
	*
	* @return  array
	*/	
    public function setToArraySection($section) {		
	
		return $this->toArraySection($this->baseSelectSection($section), $section);	

	}
	
	
	public function baseSelectSection($section)
    {
		$select = "SELECT ".$this->_nameDB.".*
				FROM `".$this->_nameDB."` AS ".$this->_nameDB;
				
		$select .= " WHERE ".$this->_nameDB.".section = '".$section."'"; 		
				
//var_dump($select);
		return $select;
	}
	
	/*
	* Populate array from $_POST
	*
	* @param string nameDB
	*
	* @return  array
	*/		
    public function toArraySection( $query, $section ) {	

        $finfo = $data = array();

        if ($result = $this->conn->query( $query )) {
            $finfo = $result->fetch_fields();
        }
//var_dump($_POST);
        foreach ($finfo as $fields) {
				if ('image' == $fields->name){
					//var_dump($_FILES['image_main']['name']);
					//die;
					if (isset($_FILES['image_main']['name']) && !empty($_FILES['image_main']['name'])){
						$data['image'] = $_FILES['image_main']['name'];
					}			
				} else {
					
					if ('seotitle' != $fields->name && 'seodescription' != $fields->name && 'seokeyword' != $fields->name){
						$data[$fields->name] = isset($_POST[$fields->name.'_'.$section]) ? $_POST[$fields->name.'_'.$section] : '';
					}else{
						$data[$fields->name] = isset($_POST[$fields->name]) ? $_POST[$fields->name] : '';
					}
				}
				
			       
        }
	
		return $data;
	}	

	
		
	
	/*
	* Insert record
	*
	* @param array data
	*
	* @return  string result
	*/	
    public function insertRecord( $data) {

	if(!$data['published'] || $data['published']=''){
		$data['published']		=	0;
	}
	
		$data['title']			=	addslashes($data['title']);
		$data['published_at']	=	date('Y-m-d:H-i');
		return $this->insert($data);

	}
	
	
	/*
	* Insert record
	*
	* @param array data
	*
	* @return  string result
	*/	
    public function copyRecord( $data) {

		unset ($data['id']);
		$data['title']			=	addslashes($data['title']);
		$data['published_at']	=	date('Y-m-d:H-i');
		return $this->insert($data);

	}
	
	
	/*
	* Update record
	*
	* @param array data
	*
	* @return  string result
	*/		
    public function updateRecord( $data) {
//var_dump($data);
//die;
    if(!$data['published']){
		$data['published']		=	1;
	}
	
		$data['title'] 			=   addslashes($data['title']);
		$data['published_at']	=	date('Y-m-d:H-i');
	
		return $this->update($data);

	}
	
	
	
	/*
	* Delete record
	*
	* @param int Id
	*
	* @return  string result
	*/
    public function deleteRecord( $cid) {
	
		parent::deleteRel($cid, 'parent_id', $this->_nameDB);
		$record = $this->findById($cid);
		if (isset($record->image) && $record->image) {
			$this->_image->deleteImage($record->image);
		}
		return parent::delete($cid);
	}
	
	/*
	* Update field active
	*
	* @param int Id
	* @param int current status
	*
	* @return  string result
	*/
    public function showRecord($cid, $current) {

		return parent::show($cid,  $current);
	}
	


}
?>