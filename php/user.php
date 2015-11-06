<?php

    include_once('adb.php');

    class user extends adb{
        function user(){}

        function validate_user($username, $password){
            $str_query="SELECT `USER_ID`, `USERNAME`, `PASSWORD`, `ROLE` FROM `mobileweb_pos_user` WHERE
            `USERNAME`=$username AND `PASSWORD`=$password";

            return $this->query($str_query);

        }

        function check_user_role(){
            $str_query="";

            return $this->query($str_query);
        }
    }

?>
