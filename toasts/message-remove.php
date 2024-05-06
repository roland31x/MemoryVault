<?php 
    session_start();
    if(isset($_POST['index'])){
        $index = $_POST['index'];
        unset($_SESSION['msgs'][$index]);
        echo "Message removed!";
    }
    else{
        echo "Error removing toast message!";
    }
?>