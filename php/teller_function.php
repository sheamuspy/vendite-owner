<?php
    if(!isset($_GET['cmd'])){
        exit();
    }

    switch($_GET['cmd']){
        case 0:
            get_products();
            break;
        case 1:
            transaction();
            break;

        default:
            break;
    }

    function get_products(){
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
            $json='{"status":0, "products":{';
            for($i=0; $i<$length; $i++){

                $bcode = $row['PRODUCT_BARCODE'];
                $json=$json.'"'.$bcode.'":'.json_encode($row);
                $row=$obj->fetch();
                if($i<$length-1){
                    $json=$json.',';
                }
            }
            $json=$json.'}}';

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

function transaction(){
    $json_trans = $_GET['trans'];
//    echo $json_trans;
    $transaction = json_decode($json_trans);

    $total=$transaction->total;
//    echo $total;
    $phone_number=$transaction->phoneNumber;
    $phone_number = "'".$phone_number."'";
//    echo $phone_number;

    $product_barcodes=$transaction->productBarcode;
//    print_r($product_barcodes);

    include_once('transaction.php');
    $obj=new transaction();

    if(!$obj->connect()){
        $json = '{"status":2, "products":{}, "message": "Failed to connect to the database."}';
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

            $json = '{"status":0, "products":{}, "message": "The transaction was added."}';
            echo $json;

    }
    else{
            $json = '{"status":1, "products":{}, "message": "The transaction was not added."}';
            echo $json;
    }



}

function send_smsgh($number, $message){
    require_once('../Smsgh/Api.php');

    //Authorization details
    $auth = new BasicAuth("yralkzfn", "znbzlsho");

    //instance of ApiHost
    $apiHost = new ApiHost($auth);
    $messagingApi = new MessagingApi($apiHost);
    try{
        $messageResponse = $messagingApi->sendQuickMessage("Important", $number, $message);

        if($messageResponse instanceof MessageResponse){
            echo "msg1:".$messageResponse->getStatus()."</br></br>";
        }else if($messageResponse instanceof HttpResponse){
            echo "\nServer Response Status:".$messageResponse->getStatus()."</br></br>";
        }

        echo "</br>success done";
        }catch(Exception $e){
    }
}
?>
