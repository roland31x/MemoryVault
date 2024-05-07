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
$owner = $memory['owner'];

$owned = $owner == $_SESSION['user'];

?>

<div class="flex flex-column flex-center text-light">
    <div class="th2" style="margin-bottom: 15px;"><?= $mem_name ?></div>

    <div class="image-viewer">
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
        Posted on <?= $posted ?> by <a class="generic-link" href="profile/<?= $owner['accountID'] ?>"><?= $owner['username'] ?></a>
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
</script>

