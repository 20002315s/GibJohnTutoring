<?php
    //uploads work details to database
    include_once("DBconnectionLink.php");

    //Uses data from form
    $taskID=$_POST["taskID"];
    $work=$_POST["work"];
    session_start();
    $username=$_SESSION["userName"];
    
    //SQL query using prepared statements to prevent against SQL injection when inserting data 
    $prepStmt=mysqli_prepare($conLink,"INSERT INTO work (work,FKusername,FKtaskID) VALUES(?,?,?)");
    mysqli_stmt_bind_param($prepStmt,"sss",$work,$username,$taskID);
    mysqli_stmt_execute($prepStmt);
    header("Location: mainDash.php");   
?>