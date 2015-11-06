<?php
    if(!isset($_GET['cmd'])){
        exit();
    }


    switch($_GET['cmd']){
        case 0:
            get_barcodes();
            break;
        case 1:
            get_product_names();
            break;
        case 2:
            get_prices();
            break;
        case 3:
            add_transaction();
            break;
        default:
            break;
    }

function get_barcodes(){

        include_once('product.php');

        $obj = new product();

        if(!$obj->connect()){
            $json = 'connection error';
            echo $json;
            exit();
        }

        if($obj->get_products()){
            $row=$obj->fetch();
            $length = $obj->get_num_rows();

//            Barcodes
            $json='';
            for($i=0; $i<$length; $i++){

                $bcode = $row['PRODUCT_BARCODE'];
                $json=$json.$bcode;
                $row=$obj->fetch();
                if($i<$length-1){
                    $json=$json.',';
                }
            }

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
            $json = 'error';
            echo $json;
        }
}


function add_transaction(){
    $json_trans = $_GET['trans'];

    $transaction = json_decode($json_trans);

    $total=$transaction->total;

    $phone_number=$transaction->phoneNumber;
    $phone_number = "'".$phone_number."'";


    $product_barcodes=$transaction->productBarcode;


    include_once('transaction.php');
    $obj=new transaction();

    if(!$obj->connect()){
        $json = "Failed to connect to the database.";
        echo $json;
    }

    if($obj->add_transaction($phone_number, $total)){
        include_once('order.php');
        $order_obj = new order();

        $order_obj->connect();

        $trans_id=$obj->get_insert_id();

        $order_obj->add_orders($trans_id, $product_barcodes);

        if($total>500){
//            $message = "You have a 10% discount the next time you purchase.";
//            send_smsgh($phone_number, $message);
        }

            $json = "The transaction was added.";
            echo $json;

    }
    else{
            $json =  "The transaction was not added.";
            echo $json;
    }
}

function get_product_names(){


        include_once('product.php');

        $obj = new product();

        if(!$obj->connect()){
            $json = 'connection error';
            echo $json;
            exit();
        }

        if($obj->get_products()){
            $row=$obj->fetch();
            $length = $obj->get_num_rows();

//            Barcodes
            $json='';
            for($i=0; $i<$length; $i++){

                $bcode = $row['PRODUCT_NAME'];
                $json=$json.$bcode;
                $row=$obj->fetch();
                if($i<$length-1){
                    $json=$json.',';
                }
            }

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
            $json = 'error';
            echo $json;
        }
}

function get_prices(){


        include_once('product.php');

        $obj = new product();

        if(!$obj->connect()){
            $json = 'connection error';
            echo $json;
            exit();
        }

        if($obj->get_products()){
            $row=$obj->fetch();
            $length = $obj->get_num_rows();

//            Barcodes
            $json='';
            for($i=0; $i<$length; $i++){

                $bcode = $row['PRODUCT_PRICE'];
                $json=$json.$bcode;
                $row=$obj->fetch();
                if($i<$length-1){
                    $json=$json.',';
                }
            }

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
            $json = 'error';
            echo $json;
        }
}

?>
