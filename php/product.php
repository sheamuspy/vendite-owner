<?php
    include_once("adb.php");

    class product extends adb{

        function product(){}

        function add_product($name, $barcode, $price){
            $str_query="INSERT INTO `mobileweb_pos_product` SET
            `PRODUCT_NAME`=$name,
            `PRODUCT_BARCODE`=$barcode,
            `PRODUCT_PRICE`=$price";

            return $this->query($str_query);
        }

        function update_pricing($barcode, $price){
            $str_query="UPDATE `mobileweb_pos_product` SET
            `PRODUCT_PRICE`=$price
            WHERE `PRODUCT_BARCODE`=$barcode";
            return $this->query($str_query);
        }

        function get_products(){
            $str_query="SELECT `PRODUCT_ID`, `PRODUCT_NAME`, `PRODUCT_BARCODE`, `PRODUCT_PRICE` FROM `mobileweb_pos_product` WHERE `PRODUCT_SOLD`=FALSE ORDER BY PRODUCT_NAME ASC";
            return $this->query($str_query);
        }

        function get_product_quantity($product_name){
            $str_query="SELECT count(`PRODUCT_ID`)QUANTITY FROM `mobileweb_pos_product` WHERE
            `PRODUCT_NAME` = $product_name AND `PRODUCT_SOLD`=FALSE";
            return $this->query($str_query);
        }

        function get_product($barcode){
            $str_query="SELECT `PRODUCT_ID`, `PRODUCT_NAME`, `PRODUCT_BARCODE`, `PRODUCT_PRICE` FROM `mobileweb_pos_product` WHERE
            `PRODUCT_SOLD`=FALSE AND `PRODUCT_BARCODE`=$barcode";

            return $this->query($str_query);
        }

        function set_group_price($name, $price){
            $str_query="UPDATE `mobileweb_pos_product` SET
            `PRODUCT_PRICE`=$price
            WHERE `PRODUCT_NAME`=$name";
            return $this->query($str_query);
        }
    }
?>
