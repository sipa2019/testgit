<?php


Class ServicesClass extends Db_Base {
	protected $_nameDB 				= 'ori_services';
    protected $_nameDB_translation  = 'ori_services_translation';
	
	/*
	* GET base SELECT 
	*
	* @param 
	*
	* @return  string 
	*/
    public function baseSelect ()
    {
		$select = "SELECT ".$this->_nameDB_translation.".*
				FROM `".$this->_nameDB_translation."` AS ".$this->_nameDB_translation;
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
		$select 	.= " WHERE ".$this->_nameDB_translation.".id =  '".$id."'";	
			
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

		$select 	.= " WHERE ".$this->_nameDB_translation.".lang = '".$lang."'";

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
		$query .= " WHERE ".$this->_nameDB_translation.".id = '".$cid."'";     

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
		
		if(!$data['published']){
			$data['published']=0;
		}
		return $this->insertTranslation($data, $this->_nameDB, $this->_nameDB_translation, 'services_id');

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

		return $this->insertRecord($data);

	}
	
	
	/*
	* Update record
	*
	* @param array data
	*
	* @return  string result
	*/		
    public function updateRecord( $data ) {
		$bd						=	$this->_nameDB_translation;
		$data['title'] 			= 	addslashes($data['title']);
		$data['published_at']	=	date('Y-m-d:H-i');
		if(!$data['published']){
			$data['published']=0;
		}
		return $this->update($data, $bd);

	}
	
	
	
	/*
	* Delete record
	*
	* @param int Id
	*
	* @return  string result
	*/
    public function deleteRecord( $cid) {
	
		parent::deleteRel($cid, 'id', $this->_nameDB);
		$record = $this->findById($cid);
		//if (isset($record->image) && $record->image) {
		//	$this->_image->deleteImage($record->image);
		//}
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

		//return parent::show($cid,  $current);
		$is_active 	=	('0'==$current) ? '1' : '0';
		$stack 		=	self::DATA_STACK_SUCCESS;			
		$query 		=	"UPDATE `".$this->_nameDB_translation."` SET
									published	= '$is_active'
									WHERE id = '".$cid."'";	
		$result = $this->conn->query($query);
		
		if (!$result){
			$stack = self::DATA_STACK_ERROR;			
		}	
      return $stack;	
	}
	




}
?>