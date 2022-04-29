<?php
    //Link to database connection 
    include_once("DBconnectionLink.php");
    //Uses data from form
    $verificationCode=$_POST["verificationCode"];
    //SQL query using prepared statements to prevent against SQL injection
    $prepStmt=mysqli_prepare($conLink,"SELECT * FROM verificationholder WHERE verificationCode=?");
    mysqli_stmt_bind_param($prepStmt,"s",$verificationCode);
    mysqli_stmt_execute($prepStmt);
    $sqldata = mysqli_stmt_get_result($prepStmt);
    $dataCheck = mysqli_fetch_assoc($sqldata);
    //checks to see if users verification code is correct
    if(isset($dataCheck)){
        header("Location: singUp.php");
    }
    //Sends user to error page if wrong
    else{
        header("Location: verifacationError.php");
    }
?>