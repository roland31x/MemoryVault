<?php

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $data = [
            'email' => $email,
            'username' => $username,
            'password' => $password
        ];

        $response = api_request($API_URL . 'Account/edit', "POST", $data, $_SESSION['lg-token']);

        if($response !== FALSE){
            if($response['status'] == 200) {
                session_destroy();
                session_start();
                add_message("Account credentials successfully edited! Please login again.");
                header("Location: /");
                exit;
            }
            else{
                $error = $response['message'];
            }
        }       
        else {
            $error = "Something went wrong connecting to server...";
        }
    }


    $response = api_request($API_URL . 'Account/lgtoken', "GET", null, $_SESSION['lg-token']);

    if($response['status'] != 200) {
        var_dump($response);
    }

    $account = $response['data'];

    $username = $account['username'];
    $email = $account['email'];
?>

<form class="input-form" action="edit" method="post">
        <div class="th2">Edit your account</div>
        <?php
                if (isset($error)) {
                echo "<div class='th4 error' style='margin: 10px 0px'>$error</div>";
                }
        ?>
        <label class="input-form-label" for="email">Email:</label>
        <input class="input-form-input" type="text" name="email" id="email" required value="<?= $email ?>">
        <br>
        <label class="input-form-label" for="username">Username:</label>
        <input class="input-form-input" type="text" name="username" id="username" required value="<?= $username ?>">
        <br>
        <label class="input-form-label" for="password">New Password:</label>
        <input class="input-form-input" type="password" name="password" id="password" required>
        <br>
        <input class="generic-button" type="submit" value="Change Account Details">
</form>