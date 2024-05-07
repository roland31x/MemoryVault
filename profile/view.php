<?php
    $response = api_request($API_URL . 'Account/profile/get/' . $acc_id, "GET", [], $_SESSION['lg-token']);

    if($response !== FALSE){
        if($response['status'] == 200) {
            $profile = $response['data'];
        }
        else{
            add_message("Profile not found!");
            header('Location: /');
            exit;
        }       
    }
    else{
        add_message("Something went wrong connecting to server...");
        header('Location: /');
        exit;
    }
?>

<div class="flex flex-column flex-center">
    <div class="th1 text-light">
        <?= $profile['username']; ?>'s Profile
    </div>
    <?php
        if(count($profile['publicMemories']) > 0){
            echo'
            <div class="th2 text-light">
                - Public Memories -
            </div>
            ';
        }
        else{
            echo'
            <div class="th2 text-light">
                - No Public Memories -
            </div>
            ';
        } 
        
    ?>
    <div class="flex flex-row flex-auto-overflow">
        <?php foreach($profile['publicMemories'] as $memory): ?>
            <a href="/memory/<?= $memory['memoryID']; ?>" class="flex flex-column flex-space-between flex-center memory-card">
                <img class="image active" src="data:image/png;base64,<?= $memory['images'][0]['bytes']; ?>" alt="Memory Image">
                <div class="memory-card-title">
                    <?= $memory['name']; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>