<?php
    //uploads users chat to database
    include_once("DBconnectionLink.php");

    //Uses data from form
    $chat = $_POST["chat"];
    
    session_start();
    $userName=$_SESSION["userName"];

    //SQL query using prepared statements to prevent against SQL injection
    $prepStmt=mysqli_prepare($conLink,"INSERT INTO chat (FKusername,chat) VALUES(?,?)");
    mysqli_stmt_bind_param($prepStmt,"ss",$userName,$chat);
    mysqli_stmt_execute($prepStmt);
    header("Location: chat.php");
?>

