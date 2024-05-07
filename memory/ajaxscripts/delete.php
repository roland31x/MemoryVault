<?php
    require_once __DIR__ . '/../../api_request.php';
    require_once __DIR__ . '/../../toasts/message-service.php';

    session_start();

    if(!isset($_SESSION['user'])){
        add_message("You do not have permission to delete memories!");
        exit;
    }

    $response = api_request($API_URL . 'Memory/delete/' . $_POST['mem_id'], "DELETE", [], $_SESSION['lg-token']);

    if($response !== FALSE){
        if($response['status'] == 200) {
            add_message($response['message']);
            exit;
        }
        else{
            add_message($response['message']);
            exit;
        }
    }       
    else {
        add_message("Something went wrong connecting to server...");
        exit;
    }
?>