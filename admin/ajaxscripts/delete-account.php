<?php
    require_once __DIR__ . '/../../api_request.php';
    require_once __DIR__ . '/../../toasts/message-service.php';

    session_start();

    if(isset($_SESSION['role']) && $_SESSION['role'] != 'admin'){
        echo "You do not have permission to delete accounts!";
    }

    echo "deleting account...";
    $response = api_request($API_URL . 'Account/admin/delete/' . $_POST['acc_id'], "DELETE", [], $_SESSION['lg-token']);

    if($response !== FALSE){
        if($response['status'] == 200) {
            add_message("Account deleted!");
        }
        else{
            add_message($response['message']);
        }
    }       
    else {
        add_message("Something went wrong connecting to server...");
    }
?>