<?php
/*
	Posts Class
*/
require_once SITE_PATH . 'model'. DIRSEP .'Posts.php';

Class PostsClass extends Db_Base {

    protected $_nameDB = 'posts';
	
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

		$select 	.= " WHERE ".$this->_nameDB.".lang = '".$lang."'";

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
		$data['slug'] 			=	$this->translitSlug($data['title']);
		$data['published_at']	=	date('Y-m-d');
		$data['created_at']		=	date('Y-m-d:H-i');
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
		$data['slug'] 			=	$this->translitSlug($data['title']);
		$data['published_at']	=	date('Y-m-d');
		$data['created_at']		=	date('Y-m-d:H-i');
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
	
		$data['title'] = addslashes($data['title']);
		if (!$data['slug']) {
			$data['slug'] = $this->translitSlug($data['title']);		
		}
		$data['published_at']	=	date('Y-m-d');
		$data['created_at']		=	date('Y-m-d:H-i');
		$data['updated_at']		=	date('Y-m-d:H-i');
		return $this->update($data);

	}
	
	/*
	* Copy record
	*
	* @param array data
	*
	* @return  string result
	*/		
  /*  public function CopyRecord( $data) {

		$data['title'] = addslashes($data['title']);
		if (!$data['slug']) {
			$data['slug'] = $this->translitSlug($data['title']);		
		}
		$data['published_at']	=	date('Y-m-d');
		$data['created_at']		=	date('Y-m-d:H-i');
		$data['updated_at']		=	date('Y-m-d:H-i');
		return $this->insert($data);

	}*/
	
	
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