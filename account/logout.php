<?php
    if(isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    if(isset($_SESSION['lg-token'])) {
        unset($_SESSION['lg-token']);
    }
    header("Location: /");
    exit;
?>