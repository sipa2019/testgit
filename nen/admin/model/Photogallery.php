<?php
Class PhotogalleryClass extends Db_Base {

    protected $_nameDB 		= 'ori_photo_gallery';
	protected $_projectsDB 	= 'ori_galleries';

	/*
	* GET base SELECT 
	*
	* @param 
	*
	* @return  string 
	*/
    public function simpleSelect ()
    {
		$select = "SELECT ".$this->_nameDB.".*
				FROM `".$this->_nameDB."` AS ".$this->_nameDB;
		return $select;
	}
	
/*
	* GET base SELECT level 0
	*
	* @param int Id
	*
	* @return  object record
	*/
    public function baseSelect ()
    {
		$select = "SELECT ".$this->_nameDB.".*, ".$this->_projectsDB.".title as title 
				FROM `".$this->_nameDB."` AS ".$this->_nameDB."
				LEFT JOIN `".$this->_projectsDB."` AS ".$this->_projectsDB."
				ON ".$this->_nameDB.".projects_id = ".$this->_projectsDB.".id 
				";
				
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
    public function paginatorCat ( $param = null, $page = 1, $limit = 20, $lang ) {

		$select = $this->baseSelect();
		
		if(isset($_GET['parent_id'])){

			$category=$_GET['parent_id'];
			$select 	.= " WHERE  ".$this->_nameDB.".projects_id = '".$category."'";

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

		if(!$data['published']){
			$data['published']	=0;
		}
		$data['published_at']	=	date('Y-m-d:H-i');

		return $this->insert($data, $this->_nameDB);

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


	
	public function listProjects($lang) {

		$select = $this->baseSelect();	


	return $this->fetchAll($select);
	 
 }



}
?>