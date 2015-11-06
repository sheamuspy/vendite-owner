<?php
    include_once('adb.php');

    class order extends adb{

        function order(){}

        function add_orders($transaction_id, $product_barcodes){
            $length = count($product_barcodes);
            for($i=0; $i<$length; $i++){

                $product_id = $this->get_product_id($product_barcodes[$i]);

                $this->add_order($transaction_id, $product_id);
                $this->sold_product($product_id);
            }
        }

        function add_order($transaction_id, $product_id){
            $str_query="INSERT INTO `mobileweb_pos_order` SET
            `TRANSACTION_ID`=$transaction_id,
            `PRODUCT_ID`=$product_id";

            return $this->query($str_query);

        }

        function sold_product($pid){
            $str_query="UPDATE `mobileweb_pos_product` SET
            `PRODUCT_SOLD`=TRUE
            WHERE `PRODUCT_ID`=$pid";
            return $this->query($str_query);
        }

        function get_product_id($barcode){
            $str_query="SELECT `PRODUCT_ID` FROM `mobileweb_pos_product`
            WHERE `PRODUCT_BARCODE`='$barcode'";

            $this->query($str_query);

            return $this->fetch()['PRODUCT_ID'];
        }
    }
?>
