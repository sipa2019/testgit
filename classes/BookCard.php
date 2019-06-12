<?php


class BookCard extends Card
{
    private $weight;

    /**
     * Card constructor.
     * @param $name
     * @param $price
     * @param $sku
     */
    public function __construct($arr)
    {
       /* $this->name		= $name;
        $this->price 	= $price;
        $this->sku 		= $sku;
        $this->weight 	= $weight;
        $this->sql = "INSERT INTO `sku` (`id`, `name`, `price`, `sku`, `weight`,`type`) VALUES (NULL, '$this->name', '$this->price', '$this->sku', '$this->weight','$type');";
*/

foreach($arr as $key => $value){
	$pole=$this->$key;
	$znac=$this->$value;
	
}


    }



}