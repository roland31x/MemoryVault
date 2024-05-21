<?php
    require_once __DIR__ . '/../../api_request.php';
    require_once __DIR__ . '/../../toasts/message-service.php';

    session_start();

    if(!isset($_SESSION['user'])){
        exit;
    }

    $response = api_request($API_URL . 'Like/' . $_POST['mem_id'], "POST", [], $_SESSION['lg-token']);

    if($response !== FALSE){
        if($response['message'] == "Memory liked."){
            echo 'liked';
            exit;
        }
        else if($response['message'] == "Memory unliked."){
            echo 'unliked';
            exit;
        }
        else{
            echo 'fail';
        }
    }       
?>