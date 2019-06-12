<?php


class DvdCard extends Card
{
    private $size;

    /**
     * Card constructor.
     * @param $name
     * @param $price
     * @param $sku
     */
    public function __construct($name, $price, $sku,$weight,$size,$height,$width,$length,$type)
    {
        $this->name = $name;
        $this->price = $price;
        $this->sku = $sku;
        $this->size = $size;
        $this->sql = "INSERT INTO `sku` (`id`, `name`, `price`, `sku`, `size`,`type`) VALUES (NULL, '$this->name', '$this->price', '$this->sku', '$this->size','$this->type');";

    }



}