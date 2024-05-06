<!-- This is the main page of the website. It will contain the login form and the registration form. -->
<?php
    session_start();
    include_once 'api_request.php';
    include_once 'toasts/message-service.php';

    if(isset($_SESSION['lg-token']) && !isset($_SESSION['user'])) {
        $resp = api_request($API_URL . 'Account/lgtoken', "GET", [], $_SESSION['lg-token']);

        if(isset($resp)) {
            $_SESSION['user'] = $resp['data']['username'];
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Vault</title>
    <link rel="stylesheet" href="/styles.css?v=2">
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

        $routes = [
            '' => 'home.php',
            'memory/submit' => 'memory/submit.php',
            'memory/edit' => 'memory/edit.php',
            'account/login' => 'account/login.php',
            'account/register' => 'account/register.php',
            'account/logout' => 'account/logout.php'
        ];

        if (array_key_exists($Url, $routes)) {
            require_once __DIR__ . '/' . $routes[$Url];
        } else {
            http_response_code(404);
            require_once __DIR__ . '/404.php';
        }
    ?>
    </div>

    <?php
        include 'footer.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>