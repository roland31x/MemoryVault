
<div class="header-div">
    <div class="th3 absolute absolute-center-h">
        Memory Vault
    </div>

    <div style="margin-left: 25px;">
        <a class="generic-link tn2" href="/">Home</a>
    </div>

    <?php
    if (isset($_SESSION['user'])) {
        echo '<div style="margin-right: 25px;">' . $_SESSION['user'] . ' | <a class="generic-link tn2" href="/account/logout">Log Out</a></div>';
    } else {
        echo '<div style="margin-right: 25px;">    
        <a style="margin-right: 10px;" class="generic-link tn2" href="/account/login">Log In</a>
        <a class="generic-link tn2" href="/account/register">Register</a>
        </div>';
    }
    ?>
</div>