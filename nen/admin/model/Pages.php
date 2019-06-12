<?php


Class PagesClass extends Db_Base {

    protected $_nameDB = 'ori_page';
	
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
		
		if(isset($_GET['parent_id'])){
			$parent_id=$_GET['parent_id'];
		}else{
			$parent_id=0;	
		}

		$select 	.= " WHERE ".$this->_nameDB.".lang = '".$lang."' AND ".$this->_nameDB.".parent_id ='".$parent_id."'";	

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
    public function setToArray( ) {		
	
		return $this->toArray($this->baseSelect());	

	}	
	
	/*
	* Insert record
	*
	* @param array data
	*
	* @return  string result
	*/	
    public function insertRecord( $data) {

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

		
		$data['title'] 			= addslashes($data['title']);
		$data['published_at']	=	date('Y-m-d:H-i');
		if($data['page'] !=3 ){
			$data['content_right']='';
		}
		
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