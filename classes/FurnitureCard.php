<?php


class FurnitureCard extends Card
{
    private $height;
    private $width;
    private $length;

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
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
        $this->sql = "INSERT INTO `sku` (`id`, `name`, `price`, `sku`,`height`,`width`,`length`,`type`) VALUES (NULL, '$this->name', '$this->price', '$this->sku', '$this->height','$this->width','$this->length','$type');";

    }



}