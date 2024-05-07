<?php
    if(isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    if(isset($_SESSION['lg-token'])) {
        unset($_SESSION['lg-token']);
    }
    if(isset($_SESSION['role'])) {
        unset($_SESSION['role']);
    }
    if(isset($_SESSION['user-id'])) {
        unset($_SESSION['user-id']);
    }
    add_message("You have been logged out successfully.");
    header("Location: /");
    exit;
?>