<?php
    //logout page
    //upont click login session will be destroyed and the home page will be refreshed 
    session_start();
    session_destroy();
    header('Location: index.php');
    exit;
?>