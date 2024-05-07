<?php 
    $response = api_request($API_URL . 'Account/admin/get', "GET", null, $_SESSION['lg-token']);
    $accounts = $response['data'];
?>

<div class="th1 text-light">
    Accounts Table
</div>

<div class="m-grid">
    <div class="th4 text-light" style="grid-row: 1; grid-column: 1;">
        Account Name
    </div>
    <div class="th4 text-light" style="grid-row: 1; grid-column: 2;">
       
    </div>
    <?php 
        foreach ($accounts as $index => $acc) {
            echo '
                <a href="/profile/' . $acc["accountID"] . '" class="admin-card th4" style="grid-row:' . $index + 2 . '; grid-column:1;">
                    ' . $acc["username"] . '
                </a>
                <div onclick="DeleteAccount(' . $acc["accountID"] . ')" class="flex flex-center generic-button red-button th4" style="grid-row:' . $index + 2 . '; grid-column:2;">
                    Delete
                </div>
            ';
        }    
    ?>
</div>
<script>
    function DeleteAccount(acc_id){
        if(confirm("Are you sure you want to delete this account?")){
            $.ajax({
                url: "/admin/ajaxscripts/delete-account.php",
                type: "POST",
                data: {acc_id: acc_id},
                success: function(result){
                    console.log(result);            
                    location.reload();
                }});
        }
    }
</script>