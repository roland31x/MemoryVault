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
                <img class="image border3 blackbg active" src="data:image/png;base64,<?= $memory['images'][0]['bytes']; ?>" alt="Memory Image">
                <div class="memory-card-title">
                    <?= $memory['name']; ?>
                </div>
                <div class="generic-button-nonhover flex flex-row flex-center th4">
                    <svg class="heart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" <?php
                        $found = false;
                        foreach($memory['likes'] as $like){
                            if($like['likerID'] == $_SESSION['user_id']){
                                $found = true;
                                break;
                            }
                        }
                        if($found){
                            echo 'fill="crimson"';
                        }
                        else{
                            echo 'fill="var(--light-text)"';
                        }
                    ?>>
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                    </svg>
                            
                    <div id="likediv" style="margin-left: 10px;">
                        <?= count($memory['likes']) ?> 
                    </div> 
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>