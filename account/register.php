<?php

    if(isset($_SESSION['user'])) {
        header("Location: /");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $req_url = $API_URL . 'Account/register';
        $data = [
                'Username' => $_POST['username'],
                'Email' => $_POST['email'],
                'Password' => $_POST['password'],         
        ]; // Data to send
        
        $responsedata = api_request($req_url, "POST", $data, null);

        if($responsedata){
                if($responsedata['status'] == 200) {
                        add_message("Account created successfully! Please login.");
                        header("Location: /account/login"); 
                        exit;
                }
                else{
                        $error = $responsedata['message'];
                }
        }       
        else {
            $error = "Something went wrong connecting to server...";
        }
    }
?>

<form class="input-form" action="register" method="post">
        <div class="th2">Register a new account</div>
        <?php
                if (isset($error)) {
                echo "<div class='th4 error' style='margin: 10px 0px'>$error</div>";
                }
        ?>
        <label class="input-form-label" for="email">Email:</label>
        <input class="input-form-input" type="text" name="email" id="email" required>
        <br>
        <label class="input-form-label" for="username">Username:</label>
        <input class="input-form-input" type="text" name="username" id="username" required>
        <br>
        <label class="input-form-label" for="password">Password:</label>
        <input class="input-form-input" type="password" name="password" id="password" required>
        <br>
        <input class="generic-button" type="submit" value="Register">
</form>