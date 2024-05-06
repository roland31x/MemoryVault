<?php

    if(isset($_SESSION['user'])) {
        header("Location: /");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if username and password are correct (you would validate against your database)
    
        $url = $API_URL . 'Account/login';
        $data = [
            'Credential' => $_POST['username'],
            'Password' => $_POST['password'],
        ];
        $responsedata = api_request($url, "POST", $data, null);
        if($responsedata){
            if($responsedata['status'] == 200) {
                $_SESSION['lg-token'] = $responsedata['data']['token'];
                add_message("Logged in successfully!");
                header("Location: /");
                exit;
            }
            else{
                $error = $responsedata['message'];
            }
        }
        else {
            $error = "Invalid username or password";
        }
    }
?>



<form class="input-form" action="login" method="post">
    <div class="th2">Log in with an existing account</div>
    <?php
        if (isset($error)) {
            echo "<div class='th4 error' style='margin: 10px 0px'>$error</div>";
        }
    ?>
    <label class="input-form-label" for="username">Username:</label>
    <input class="input-form-input" type="text" name="username" id="username" required>
    <br>
    <label class="input-form-label" for="password">Password:</label>
    <input class="input-form-input" type="password" name="password" id="password" required>
    <br>
    <input class="generic-button" type="submit" value="Login">
</form>