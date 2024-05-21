<?php

$response = api_request($API_URL . 'Memory/get/' . $mem_id, "GET", null, $_SESSION['lg-token']);

if($response === FALSE) {
    header('Location: /404');
    exit;
}

if($response['status'] != 200) {
    header('Location: /404');
    exit;
}

$memory = $response['data'];

$posted = date('F jS, Y', strtotime($memory['postDate']));
$mem_name = $memory['name'];
$mem_desc = $memory['description'];
$mem_images = $memory['images'];

$owned = $memory['ownerID'] == $_SESSION['user_id'];

?>

<div class="flex flex-column flex-center text-light">
    <div class="flex flex-row flex-center" style="margin-bottom: 15px;">
        <div class="th2">
            <?= $mem_name ?>
        </div>
        <div class="generic-button flex flex-row flex-center th4" onclick="LikePost()">
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
    </div>

    <div class="image-viewer">
        <?php
            if(count($mem_images) > 1){
                echo '
                <div class="image-browser abs-left-align" onclick="PrevImg()">
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>
                </div>
                <div class="image-browser abs-right-align" onclick="NextImg()">
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                    </svg>
                </div>
                ';           
            }
        ?>
        
        <?php foreach ($mem_images as $index => $image): ?>
            <img class="image<?= $index === 0 ? ' active' : '' ?>" src="data:image/png;base64,<?= $image['bytes'] ?>" alt="Memory Image">
        <?php endforeach; ?>
        
    </div>

    <?php
        if(!($mem_desc == "" || $mem_desc == null)) {
            echo"
            <div class='desc-box'>
                <div class='th4'>$mem_desc</div>
            </div>
            ";
        }
    ?>

    <div class="th4" style="margin-top: 15px;">
        Posted on <?= $posted ?> by <a class="generic-link" href="/profile/<?= $memory['ownerID'] ?>"><?= $memory['ownerName'] ?></a>
    </div>
    
    <?php 
        if($owned) {
            echo "
            <form class='input-form' style='margin: 30px;' action='/memory/edit' method='GET'>
                <input type='hidden' name='mem_id' value='$mem_id'>
                <input class='generic-button' type='submit' value='Edit Memory'>
            </form>
            ";
        } 
    ?>
    
</div>

<script>
    var images = document.querySelectorAll('.image');
    var current = 0;

    function NextImg(){
        images[current].classList.remove('active');
        current = (current + 1) % images.length;
        images[current].classList.add('active');
    }

    function PrevImg(){
        images[current].classList.remove('active');
        current = (current - 1 + images.length) % images.length;
        images[current].classList.add('active');
    }

    function LikePost(){

        $.ajax({
            url: '/memory/ajaxscripts/like.php',
            type: 'POST',
            data: {
                mem_id: <?= $mem_id ?>
            },
            success: function(data){
                console.log(data);
                if(data == 'liked'){
                    var likediv = document.getElementById('likediv');
                    likediv.innerText = parseInt(likediv.textContent) + 1;
                    var heart = document.querySelector('.heart');
                    heart.setAttribute('fill', 'crimson');
                }
                else if(data == 'unliked'){
                    var likediv = document.getElementById('likediv');
                    likediv.innerText = parseInt(likediv.textContent) - 1;
                    var heart = document.querySelector('.heart');
                    heart.setAttribute('fill', 'var(--light-text)');
                }
                else{
                    alert('Something went wrong...');
                }
            }
        });
    }
</script>

