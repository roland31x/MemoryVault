<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];

        $images = $_FILES['images'];
        $visibility = $_POST['visibility'];
        $img_bytes = [];

        foreach($images['tmp_name'] as $key => $tmp_name){
            $img_bytes[] = base64_encode(file_get_contents($tmp_name));
        }

        $req_url = $API_URL . 'Memory/create';
        $data = [
            'Name' => $name,
            'Description' => $description,
            'Images' => $img_bytes,
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

    }
?>


<form class="input-form" action="submit" method="post" enctype="multipart/form-data">
        <div class="th2">Create a new memory</div>
        <?php
                if (isset($error)) {
                echo "<div class='th4 error' style='margin: 10px 0px'>$error</div>";
                }
        ?>
        <label class="input-form-label" for="name">Name:</label>
        <input class="input-form-input" type="text" name="name" id="name" required>
        <br>
        <label class="input-form-label" for="description">Description:</label>
        <textarea class="input-form-input" name="description" id="description" style="width: 80%; min-height: 30vh; max-height:100vh; resize:vertical"></textarea>
        <br>
        <label class="input-form-label" for="images">Images:</label>
        <label class="tn1" for="images">Note: You can select multiple images at once.</label>
        <br>
        <input type="file" name="images[]" id="images" multiple accept="image/*" required>
        <br>
        <div class="flex flex-row flex-center">
            <label class="input-form-label" for="visibility" style="margin-right: 10px;">Visibility:</label>
            <select class="input-form-input" name="visibility" id="visibility" required>
                <option value="false">Private</option>
                <option value="true">Public</option>           
            </select>
        </div>
        <br>
        <input class="generic-button" type="submit" value="Create">
</form>