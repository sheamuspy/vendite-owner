<?php
    include_once("adb.php");

    class transaction extends adb{

        function transaction(){}

        function add_transaction($phone_number, $total){
        $str_query="INSERT INTO `mobileweb_pos_transaction` SET
        `PHONE_NUMBER`=$phone_number,
        `TOTAL`=$total";

            return $this->query($str_query);
        }
    }
?>
