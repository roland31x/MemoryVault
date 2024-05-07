<?php
    
    function drawLoggedIn(){

        echo '
        <div class="th1 text-light">
            Welcome back, '. $_SESSION['user'] . '.
        </div>
        
        <div class="th4 text-light">
            Got a memory to cherish?
        </div>
        <a href="/memory/submit" class="generic-button" style="margin-top: 15px; width: 30%; text-decoration: none; text-align: center;">
            Create Memory
        </a>
        ';

    }

    function drawLoggedOut(){
        echo '
                <div class="th1 text-light">
                    Welcome to Memory Vault!
                </div>
                <div class="th4 text-light">
                    Please proceed to log into your account to access all the features.
                </div>
                <a href="/account/login" class="generic-button" style="margin-top: 15px; width: 10%; text-decoration: none; text-align: center;">
                    Log In
                </a>
                <div class="th4 text-light" style="margin-top: 15px;">
                    Don\'t have an account?
                </div>
                <a href="/account/register" class="generic-button" style="margin-top: 15px; width: 10%; text-decoration: none; text-align: center;">
                    Register
                </a>
            ';
    }
?>

<div class="flex flex-column flex-center flex-center-v">
        <?php
            if(isset($_SESSION['user'])){
                drawLoggedIn();
            }
            else{
                drawLoggedOut();
            }
        ?>
</div>
