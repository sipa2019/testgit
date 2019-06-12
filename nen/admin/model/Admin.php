<?php
Class AdminClass extends Db_Base {

	
    protected $_nameDB = 'ori_admin';	
	
    public function findById($id)
    {
		if (!$id) {
			return false;
		}
		$select = "	SELECT ".$this->_nameDB.".*
					FROM `".$this->_nameDB."` AS ".$this->_nameDB."
					WHERE ".$this->_nameDB.".id = '".$id."'";
				
		return $this->fetchRow($select);		
    }
	
    public function getAuth($login, $password)
    {
		if (!$login || !$password) {
			return false;
		}
		$select = "	SELECT ".$this->_nameDB.".*
					FROM `".$this->_nameDB."` AS ".$this->_nameDB."
					WHERE ".$this->_nameDB.".login = '".$login."' AND ".$this->_nameDB.".password = '".$password."'";
				
		return $this->fetchRow($select);		
    }	

	public function getAdmins() 
    {
		$select = "	SELECT ".$this->_nameDB.".*
					FROM `".$this->_nameDB."` AS ".$this->_nameDB."							
					ORDER BY ".$this->_nameDB.".title ";
		return $this->fetchAll($select);		
	}	
	
    public function insertRecord( $data) {
	
		$data['title'] = addslashes($data['title']);
		$data['slug'] = $this->translitSlug($data['title']);
		return parent::insert($data);

	}
	
    public function updateRecord( $data) {
	
		$data['title'] = addslashes($data['title']);
		if (!$data['slug']) {
			$data['slug'] = $this->translitSlug($data['title']);		
		}
		return parent::update($data);

	}			
	
    public function deleteRecord( $cid) {

		$record = $this->findById($cid);
		if (isset($record->image) && $record->image) {
			$this->_image->deleteImage($record->image);
		}

		return parent::delete($cid);

	}		
	
    public function setPOST( $cid=null ) {		
        $query = "SELECT * FROM `".$this->_nameDB."` WHERE id = '".$cid."'";         
		return parent::populate($query);	

	}

    public function setToArray( ) {		
	
		return parent::toArray('SELECT * FROM `'.$this->_nameDB.'`');	

	}	

}
?>