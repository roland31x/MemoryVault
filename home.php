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

                    if($memory['likedByUser']){
                        $fillcolor = 'fill="crimson"';
                    }
                    else{
                        $fillcolor = 'fill="var(--light-text)"';
                    }

                    echo '
                    <a href="/memory/' . $memory['memoryID'] . '" class="flex flex-space-between flex-column flex-center memory-card" style="margin-right: 15px;">
                        <img class="image border3 blackbg active" src="data:image/png;base64,' . $memory['mainImage']['bytes'] . '" alt="Memory Image">
                        
                            <div class="memory-card-title">
                                ' . $memory['name'] . '
                            </div>
                            
                            <div class="memory-card-sub-title">
                                Shared by ' . $memory['ownerName'] . '
                            </div>

                            <div class="generic-button-nonhover flex flex-row flex-center th4">
                                <svg class="heart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"' . $fillcolor . '>
                                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                </svg>
                                        
                                <div id="likediv" style="margin-left: 10px;">
                                    ' . $memory['likes'] . ' 
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
