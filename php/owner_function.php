<?php

    if(!isset($_GET['cmd'])){
        exit();
    }

    switch($_GET['cmd']){
        case 0:
            product_inventory();
            break;
        case 1:
            add_product();
            break;
        case 2:
            set_pricing();
            break;
        case 3:
            product_quantity();
            break;
        case 4:
            get_product();
            break;
        case 5:
            validate();
            break;
        case 6:
            set_group_price();
            break;
        default:
            break;
    }

    function validate(){
        $username = $_GET['username'];
        $password = $_GET['password'];

        include('user.php');

        $obj = new user();

        if(!$obj->connect()){
            $json = '{"status":2, "products":{}}';
            echo $json;
            exit();
        }

        if($obj->validate_user($username, $password)){
            $row = $obj->fetch();
            $json = '{"status":0, "user":'.json_encode($row).'}';
            echo $json;
        }
        else{
            $json = '{"status":1, "products":{}}';
            echo $json;
        }

    }

   function product_inventory(){
        include_once('product.php');

        $obj = new product();

        if(!$obj->connect()){
            $json = '{"status":2, "products":{}}';
            echo $json;
            exit();
        }

        if($obj->get_products()){
            $row=$obj->fetch();
            $length = $obj->get_num_rows();

//            Products as a set
            $json='{"status":0, "products":[';
            for($i=0; $i<$length; $i++){

                //$bcode = $row['PRODUCT_NAME'];
                $json=$json.json_encode($row);
                $row=$obj->fetch();
                if($i<$length-1){
                    $json=$json.',';
                }
            }
            $json=$json.']}';

//            Products as an array
//            $json='{"status":0, "products":[';
//            for($i=0; $i<$length; $i++){
//
//                $bcode = $row['PRODUCT_BARCODE'];
//                $json=$json.'{"'.$bcode.'":'.json_encode($row).'}';
//                $row=$obj->fetch();
//                if($i<$length-1){
//                    $json=$json.',';
//                }
//            }
//            $json=$json.']}';
            echo $json;
//            $d = json_decode($json);
//            print_r($d);
        }
        else{
            $json = '{"status":1, "products":{}}';
            echo $json;
        }

    }

    function add_product(){
        $name=$_GET['name'];
        $barcode=$_GET['barcode'];
        $price=$_GET['price'];

        include_once('product.php');

        $obj = new product();

        if(!$obj->connect()){
            $json = '{"status":2, "products":{}, "Failed to connect to the database."}';
            echo $json;
            exit();
        }

        if($obj->add_product($name, $barcode, $price)){
            $json = '{"status":0, "products":{}, "message":"Product added."}';
            echo $json;

        }
        else{
            $json = '{"status":1, "products":{}, "message":"Product was not added."}';
            echo $json;
        }

    }

    function get_product(){
        include_once('product.php');

        $barcode=$_GET['barcode'];

        $obj=new product();

        if(!$obj->connect()){
            $json = '{"status":2, "products":{}, "message":"Failed to connect to the database."}';
            echo $json;
            exit();
        }

        if($obj->get_product($barcode)) {
            $row = $obj->fetch();
            $json = '{"status": 0, "products":'.json_encode($row).', "message": "Found product."}';
            echo $json;
        } else{
            $json = '{"status":1, "products":{}, "message":"Sorry we could not execute that."}';
            echo $json;
        }
    }

    function set_pricing(){
        include_once('product.php');

        $barcode=$_GET['barcode'];
        $price=$_GET['price'];

        $obj=new product();

        if(!$obj->connect()){
            $json = '{"status":2, "products":{}, "message":"Failed to connect to the database."}';
            echo $json;
            exit();
        }

        if($obj->update_pricing($barcode, $price)){
            $json = '{"status":0, "products":{}, "message":"The price was changed."}';
            echo $json;
        }
        else{
            $json = '{"status":1, "products":{}, "message":"The price was not changed."}';
            echo $json;
        }
    }

    function product_quantity(){
        include_once('product.php');

        $name = $_GET['product_name'];

        $obj = new product();

        if(!$obj->connect()){
            $response = 'Not connected';
            echo $response;
            exit();
        }

        if($obj->get_product_quantity($name)){
            $row = $obj->fetch()['QUANTITY'];
            $response = "Quantity of ".$name." is ".$row;
            echo $response;
        }
        else{
            $response = 'Not Found';
            echo $response;
        }
    }

    function set_group_price(){
        include_once('product.php');

        $name = $_GET['name'];
        $price = $_GET['price'];

        $obj = new product();

        if(!$obj->connect()){
            $json = '{"status":2, "products":{}, "Failed to connect to the database."}';
            echo $json;
            exit();
        }

        if($obj->set_group_price($name, $price)){
            $json = '{"status":0, "products":{}, "message":"The price was changed."}';
            echo $json;
        }
        else{
            $json = '{"status":1, "products":{}, "message":"The price was not changed."}';
            echo $json;
        }
    }
?>
