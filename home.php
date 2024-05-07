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
            Create One
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

                $random_memories = api_request($API_URL . 'Memory/random', "GET", null, $_SESSION['lg-token']);

                echo '
                <div class="th3 text-light" style="margin-top: 45px;">
                    Here are some memories others shared:
                </div>
                <div class="flex flex-auto-overflow flex-row flex-center flex-center-v" style="max-width: 100%">
                ';
                foreach($random_memories['data'] as $memory){
                    echo '
                    <a href="/memory/' . $memory['memoryID'] . '" class="flex flex-space-between flex-column memory-card" style="margin-right: 15px;">
                        <img class="image active" src="data:image/png;base64,' . $memory['images'][0]['bytes'] . '" alt="Memory Image">
                        <div class="flex flex-column">
                            <div class="memory-card-title">
                                ' . $memory['name'] . '
                            </div>
                            <div class="memory-card-sub-title">
                                Shared by ' . $memory['owner']['username'] . '
                            </div>
                        </div>
                    </a>
                    ';
                }
                echo '</div>';
            }
            else{
                drawLoggedOut();
            }
        ?>
</div>
