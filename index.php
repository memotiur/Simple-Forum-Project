<?php
    $login_status=1;
    require_once('inc/header.php');

    if(isset($_GET['page'])){
        if ($_GET['page'] == 'login') {
            include('views/login.php');
        }else if ($_GET['page'] == 'registration') {
            include('views/registration.php');
        }else if ($_GET['page'] == 'create_thread') {
            include('views/create_thread.php');
        }else if ($_GET['page'] == 'logout') {
            include('views/logout.php');
        }
    }else{
        require('views/main_content.php');
    }
    require('inc/footer.php');

?>


