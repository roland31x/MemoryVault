<?php
    function add_message($msg){
        if(!isset($_SESSION['msgs'])){
            $_SESSION['msgs'] = [];
        }
        array_push($_SESSION['msgs'], $msg);
    }
?>