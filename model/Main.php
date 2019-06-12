<?php
/**
 * Class MainClass
 *
 *  Model
 *  DataBase Methods
 *
 *
 */


Class MainClass extends Db_Base {

    protected $nameTable = 'sku';


    public function showPage ()
    {
        $row	=	array();
        $select = $this->baseSelect();

        $row=$this->fetchAll($select);

        return $row;
    }




    /*  read from DB  */
    public function baseSelect ()
    {
        $select = "SELECT ".$this->nameTable.".* 
				FROM `".$this->nameTable."` AS ".$this->nameTable."
				";
        return $select;
    }

    /*   write to DB  */
    public function baseUpdate ($product)
    {

    //    $this->sql = "INSERT INTO `sku` (`id`, `name`, `price`, `sku`, `size`, `weight`, `height`,`width`,`length`,`type`) VALUES (NULL, '$this->name', '$this->price', '$this->sku', '$this->size', '$this->weight','$this->h','$this->w','$this->l','$this->type');";
    $sql =  $product->getSql();
   // Connect to DB via parents class method
        $link = $this->baseConnect();
// Check connection
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

// Attempt insert query execution
        if(mysqli_query($link, $sql)){
            header("Location: /");
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }

// Close connection
        mysqli_close($link);

    }

    /*
	* Delete record
	*
	* @param int Id
	*
	* @return  string result
	*/


    public function deleteRecord( $cid) {

        $link = $this->baseConnect();

        $stack = true;
        $sql = "DELETE FROM `".$this->nameTable."` WHERE id='".$cid."'";

        if(mysqli_query($link, $sql)){
            $stack = true;
        } else{
            $stack = false;
        }

        return $stack;
    }



}
