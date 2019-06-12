<?php

abstract class CardFactory {



    public static function build ($arr)
    {

/*foreach($arr as $key => $value){
	var_dump($key);
	var_dump($value);
//INSERT INTO `sku` (`id`, `name`, `price`, `sku`, `weight`,`type`) VALUES (NULL, '$this->name', '$this->price', '$this->sku', '$this->weight','$type');";

	
}*/
















        if($type == '') {
            throw new Exception('Invalid Card Type.');
        } else {
            $className = ucfirst($arr['type']) . 'Card';

            // Assuming Class files are already loaded using autoload concept
            if(class_exists($className)) {
                $classBean = new $className($arr);
                return $classBean;
            } else {
                throw new Exception('Card type not found.');
            }
        }
    }
}