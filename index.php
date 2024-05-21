<?php
    session_start();
    include_once 'api_request.php';
    include_once 'toasts/message-service.php';

    if(isset($_SESSION['lg-exp']) && $_SESSION['lg-exp'] < time()){
        session_destroy();
        session_start();
        add_message("Session expired, please login again!");
    }

    if(isset($_SESSION['lg-token']) && !isset($_SESSION['user'])) {
        $resp = api_request($API_URL . 'Account/lgtoken', "GET", [], $_SESSION['lg-token']);
        if($resp) {
            $_SESSION['user'] = $resp['data']['username'];
            $_SESSION['user_id'] = $resp['data']['accountID'];
            if($resp['data']['isAdmin'] == true) {
                $_SESSION['role'] = 'admin';
            }
            else{
                $_SESSION['role'] = 'user';
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Vault</title>
    <link rel="stylesheet" href="/styles.css?v=1">
</head>
<body class="body-div">
    <?php
        include 'header.php';
        include 'toasts/messages.php';
    ?>
    <div class="main-container">
    <?php 
        $Url = isset($_GET['url']) ? $_GET['url'] : '/';
        $Url = rtrim($Url, '/'); 

        $available_routes = [
            '' => 'home.php',
            'account/login' => 'account/login.php',
            'account/register' => 'account/register.php',
            'account/logout' => 'account/logout.php',
        ];

        $loggedin_routes = [
            'account/edit' => 'account/edit.php',
            'memory' => 'memory/memory.php',
            'memory/submit' => 'memory/submit.php',
            'memory/edit' => 'memory/edit.php',
            'memory/browse' => 'memory/browse.php',
        ];

        $admin_routes = [
            'admin/main' => 'admin/main.php',
            'admin/users' => 'admin/users.php',
            'admin/memories' => 'admin/memories.php',
        ];

        if(isset($_SESSION['user'])) {
            $available_routes = array_merge($available_routes, $loggedin_routes);
            
            $mem_pattern = "/memory\/(\d+)/";
            if (preg_match($mem_pattern, $Url, $matches)) {
                $mem_id = $matches[1];
            }

            $acc_pattern = "/profile\/(\d+)/";
            if (preg_match($acc_pattern, $Url, $matches)) {
                $acc_id = $matches[1];
            }
        }

        if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            $available_routes = array_merge($available_routes, $admin_routes);
        }

        if(preg_match("/\.php$/", $Url)) {
            header('Location: /404');
            exit;
        }
        else{
            if(array_key_exists($Url, $available_routes)) {
                require_once __DIR__ . '/' . $available_routes[$Url];
            } else if(isset($mem_id)) {
                require_once __DIR__ . '/memory/memory.php';
            } else if(isset($acc_id)){
                require_once __DIR__ . '/profile/view.php';
            } else {
                require_once __DIR__ . '/404.php';
                exit;
            }
        }
    ?>
    </div>

    <?php
        include 'footer.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>