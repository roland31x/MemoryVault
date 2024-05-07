<?php
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $mem_id = $_GET['mem_id'];
        
        $response = api_request($API_URL . 'Memory/get/' . $mem_id, "GET", null, $_SESSION['lg-token']);
        
        if($response['status'] != 200) {
            header('Location: /404');
            exit;
        }
        
        $memory = $response['data'];
        
        $mem_name = $memory['name'];
        $mem_desc = $memory['description'];
        $mem_images = $memory['images'];
        $mem_visibility = $memory['public'] == true ? 'true' : 'false';
        
        $owned = $memory['owner']['username'] == $_SESSION['user'];

        if($owned === false){
            header('Location: /404');
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $visibility = $_POST['visibility'];
        
        $mem_id = $_POST['mem_id'];

        $req_url = $API_URL . 'Memory/edit/' . $mem_id;
        $data = [
            'Name' => $name,
            'Description' => $description,
            'Images' => [], // Not implemented yet
            'Public' => $visibility,
        ];

        $responsedata = api_request($req_url, "POST", $data, $_SESSION['lg-token']);

        if($responsedata !== FALSE){
            if($responsedata['status'] == 200) {
                add_message($responsedata['message']);
                header("Location: /memory/" . $responsedata['data']['memoryID']); 
                exit;
            }
            else{
                $error = $responsedata['message'];
            }
        }       
        else {
            $error = "Something went wrong connecting to server...";
        }

        $response = api_request($API_URL . 'Memory/get/' . $mem_id, "GET", null, $_SESSION['lg-token']);
        
        if($response['status'] != 200) {
            header('Location: /404');
            exit;
        }
        
        $memory = $response['data'];
        
        $mem_name = $memory['name'];
        $mem_desc = $memory['description'];
        $mem_images = $memory['images'];
        $mem_visibility = $memory['public'] == true ? 'true' : 'false';

        $owned = $memory['owner']['username'] == $_SESSION['user'];

        if($owned === false){
            header('Location: /404');
            exit;
        }
    }
?>

<form class="input-form" action="edit" method="post" enctype="multipart/form-data">
    <div class="flex flex-row flex-center flex-center-v">
        <div class="th2">Edit memory</div>
        <input type="button" class="generic-button red-button" style='margin: 10px' onclick="confirmDelete(<?= $mem_id ?>)" value="Delete Memory">
    </div>
    
    <?php
            if (isset($error)) {
            echo "<div class='th4 error' style='margin: 10px 0px'>$error</div>";
            }
    ?>
    <label class="input-form-label" for="name">Name:</label>
    <input class="input-form-input" type="text" name="name" id="name" value="<?= $mem_name ?>" required>
    <br>
    <label class="input-form-label" for="description">Description:</label>
    <textarea class="input-form-input" name="description" id="description" style="width: 80%; min-height: 30vh; max-height:100vh; resize:vertical"><?= $mem_desc ?></textarea>
    <br>
    <label class="input-form-label" for="images">Images:</label>
    <label class="tn1" for="images">Note: You cannot change images yet.</label>
    <br>
    <br>
    <div class="flex flex-row flex-center">
        <label class="input-form-label" for="visibility" style="margin-right: 10px;">Visibility:</label>
        <select class="input-form-input" name="visibility" id="visibility" required>
            <option value="false" <?= $mem_visibility === 'false' ? 'selected' : '' ?>>Private</option>
            <option value="true" <?= $mem_visibility === 'true' ? 'selected' : '' ?>>Public</option>            
        </select>
    </div>
    <br>
    <input type="hidden" name="mem_id" value="<?= $mem_id ?>">
    <input class="generic-button" type="submit" value="Save Memory">
</form>

<script>
    function confirmDelete(mem_id){
        if(confirm("Are you sure you want to delete this memory?")){
            if(confirm("This action is irreversible. Are you sure?")){
                $.ajax({
                    url: '/memory/ajaxscripts/delete.php',
                    type: 'POST',
                    data: {mem_id: mem_id},
                    success: function(response){
                        window.location.href = '/';
                    }
                });
            }
        }
    }
</script>
