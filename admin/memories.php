<?php 
    $response = api_request($API_URL . 'Memory/admin/get', "GET", null, $_SESSION['lg-token']);
    $total_memories = $response['data'];
?>

<div class="th1 text-light">
    Memories Table
</div>

<div class="m-grid">
    <div class="th4 text-light" style="grid-row: 1; grid-column: 1;">
        Name
    </div>
    <div class="th4 text-light" style="grid-row: 1; grid-column: 2;">
        Owner
    </div>
    <div class="th4 text-light" style="grid-row: 1; grid-column: 3;">
        Likes
    </div>
    <div class="th4 text-light" style="grid-row: 1; grid-column: 4;">
        Public
    </div>
    <?php 
        foreach ($total_memories as $index => $memory) {
            echo '
                <a href="/memory/' . $memory["memoryID"] . '" class="admin-card th4" style="grid-row:' . $index + 2 . '; grid-column: 1;">
                    ' . $memory["name"] . '
                </a>
                <a href="/profile/' . $memory["ownerID"] . '" class="admin-card th4" style="grid-row:' . $index + 2 . '; grid-column:2;">
                    ' . $memory["owner"]["username"] . '
                </a>
                <div class="admin-card th4" style="grid-row:' . $index + 2 . '; grid-column: 3; text-align: center;">
                    ' . 0 . '
                </div>
                <div class="admin-card th4" style="grid-row:' . $index + 2 . '; grid-column: 4; text-align: center;">
                    ' . ($memory["public"] === true ? "yes" : "no") . '
                </div>
                <div onclick="DeleteMemory(' . $memory["memoryID"] . ')" class="flex flex-center generic-button red-button th4" style="grid-row:' . $index + 2 . '; grid-column:5;">
                    Delete
                </div>
            ';
        }    
    ?>
</div>
<script>
    function DeleteMemory(mem_id){
        if(confirm("Are you sure you want to delete this memory?")){
            $.ajax({
                url: "/memory/ajaxscripts/delete.php",
                type: "POST",
                data: {mem_id: mem_id},
                success: function(data){            
                    location.reload();
                }});
        }
    }
</script>