<?php
class Image {

	private $registry;
	
    private  $_allowedExtensions	= array(
		"image/jpeg" => "jpg", 
		"image/png" => "png",
		"image/gif" => "gif"
	);

    private $_thumb     = THUBN;
    private $_fieldName     = "image";	
    private $_sizeThmb     = null;	    	

    protected static $_error = null;	
    
	const ERROR_UPLOAD = 'Not upload file';
    const ERROR_SIZE = 'More max size';
    const ERROR_TYPE = 'Not true type';
    const ERROR_DOWNLOAD = 'Bad download';	
	
	function __construct() {

	}
	

    public function isValid ($image = null)
    {
		$image = $this->setDefaultNameField($image);

		if (!isset($_FILES[$image])){
			$_error = self::ERROR_UPLOAD;
		} elseif (!is_uploaded_file($_FILES[$image]['tmp_name'])){
			$_error = self::ERROR_UPLOAD;
		} elseif ($_FILES[$image]['error']==3 || $_FILES[$image]['error']==4){
			$_error = self::ERROR_UPLOAD;
		} elseif ($_FILES[$image]['error']==1 || $_FILES[$image]['error']==2){
			$_error = self::ERROR_SIZE;
		} elseif (!array_key_exists($_FILES[$image]['type'], $this->_allowedExtensions)){
			$_error = self::ERROR_TYPE;		
		}
		return array(
			'success' => $_error?false:true,
			'message' => $_error
		);
	} 
	
	

    public function uploadImage($maxLenght = null, $image = null)
    {
		$image = $this->setDefaultNameField($image);
	
		$extension = $this->guessClientExtension($image);		
		$finalFilename = $this->randomFilenamer($extension);
			
		if ($maxLenght) {
			$this->createThumbnail($finalFilename, $maxLenght, $image);
		}
		$result = move_uploaded_file($_FILES[$image]['tmp_name'],IMAGE_PATH.$finalFilename);

		if ($result){

			return array(
				'success' => true,
				'image' => $finalFilename
			);
		}
		return array(
			'success' => false,
			'message' => self::ERROR_DOWNLOAD
		);		
	}
	
    public function deleteImage($image)
    {

		$filename = IMAGE_PATH.$image;
		if (file_exists($filename)) {
			chmod($filename, 0750);
			unlink($filename);
		}
		$filename =  IMAGE_PATH.$this->_thumb.$image;
		if (file_exists($filename)) {
			chmod($filename, 0750);
			unlink($filename);
		}
		
	}	
	
	private function createThumbnail($newname, $maxLenght, $image) {	
		

		$size		= getimagesize($_FILES[$image]['tmp_name']);
		$width		= $size[0];
		$height		= $size[1];	

		if ($width>$maxLenght) $newwidth=$maxLenght; else $newwidth=$width;
		$newheight	= intval($height*($newwidth/$width));
		
		// only jpg thumbnail

		if ("image/jpeg" == $_FILES[$image]['type']) {
			$oldimage  = ImageCreateFromJPEG($_FILES[$image]['tmp_name']);
	
			$newimage  = ImageCreateTrueColor($newwidth,$newheight);
			ImageCopyResampled($newimage,$oldimage,0,0,0,0,$newwidth,$newheight,$width,$height);		
		
			$filename	= IMAGE_PATH.$this->_thumb.$newname;		
			ImageJPEG($newimage, $filename);		
			
	
		}
			
	}
	
	
	private function randomFilenamer($extension) {
		$x=0;
		while ($x==0){
			$newname 	= $this->generatorName().'.'.$extension;
			$filename	= IMAGE_PATH.$newname;
			if (!file_exists($filename)) $x=1;
		}	
		return $newname;
	}	
	
	private function guessClientExtension($image = null) {
		$image = $this->setDefaultNameField($image);
		return $this->_allowedExtensions[$_FILES[$image]['type']];
	}
	
	private function generatorName() {
	
		$cis = mt_rand(0,25);
		$cif = mt_rand(0,25);
		$buk = "abcdefghijklmnopqrstuvwxyz";
		$buc = "qwertyuioplkjhgfdsazxcvbnm";
		$b=substr($buk,$cis,1);
		$c=substr($buc,$cif,1);
		$d=substr($buc,$cis,2);
		$cis = mt_rand(10,20);
		$cif = mt_rand(0,10);
		$cid = mt_rand(11,99);
		$cia = mt_rand(10,20);
		$result = $cid.$b.$cis.$c.$d.$cif.$cia.'-'.$cis.$d.$cid.$c.'-'.$cif.$b.$c.$d.$cis.$cia;
	
		return $result;
	}	
	
    private function setDefaultNameField($image=null)
    {
		return ($image)?$image:$this->_fieldName;	
	}
	
    public function setImageValue($value)
    {
        if (!$value) {
			return array(
				'success' => false,
				'message' => self::ERROR_DOWNLOAD
			);		
		}	
	
        $this->_imageValue = $value;
        return $this;
    }	

}
?>