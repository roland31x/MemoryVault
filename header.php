
<div class="header-div">
    <div class="th3 absolute absolute-center-h">
        Memory Vault
    </div>

    <div style="margin-left: 25px;">
        <a class="generic-link tn2" href="/">Home</a>
        <?php
        if(isset($_SESSION['user'])) {
            echo ' 
                    <a class="generic-link tn2" style="margin-left: 25px;" href="/memory/browse">Your Memories</a>
                    <a class="generic-link tn2" style="margin-left: 25px;" href="/profile/'. $_SESSION['user_id'] .'">Your Profile</a>
                ';
        }
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            echo ' 
                    <a class="generic-link tn2" style="margin-left: 25px;" href="/admin/main">Admin</a>
                ';
        } 
        ?>
    </div>

    <?php
    if (isset($_SESSION['user'])) {
        echo '
        <div class="tn2 flex flex-row flex-center" style="margin-right: 25px;">
            <a class="generic-link tn2" href="/account/edit">
                ' . $_SESSION['user'] . '
            </a> 
            <div style="margin-left: 10px; margin-right: 10px;">
                |
            </div>    
            <a class="generic-link tn2" href="/account/logout">
                Log Out
            </a>
        </div>';
    } else {
        echo '
        <div style="margin-right: 25px;">    
            <a style="margin-right: 10px;" class="generic-link tn2" href="/account/login">Log In</a>
            <a class="generic-link tn2" href="/account/register">Register</a>
        </div>';
    }
    ?>

</div>
<hr class="custom-hr">