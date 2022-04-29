<?php
    // uploads task infomation to database
    include_once("DBconnectionLink.php");
    
    //Uses data from task creation form
    $taskCreationHeader=$_POST["taskCreationHeader"];
    $taskCreationDescription=$_POST["taskCreationDescription"];

    //SQL query using prepared statements to prevent against SQL injection
    $prepStmt=mysqli_prepare($conLink,"INSERT INTO task (taskCreationHeader,taskCreationDescription) VALUES(?,?)");
    mysqli_stmt_bind_param($prepStmt,"ss",$taskCreationHeader,$taskCreationDescription);
    mysqli_stmt_execute($prepStmt);
    header("Location: mainDash.php");
?>