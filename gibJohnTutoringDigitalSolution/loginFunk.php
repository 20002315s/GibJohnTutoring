<?php
    //Link to database connection 
    include_once("DBconnectionLink.php");

    //Uses data from form
    $userName=$_POST["userName"];
    $password=$_POST["password"];

    //SQL query using prepared statements to prevent against SQL injection
    $prepStmt=mysqli_prepare($conLink,"SELECT * FROM newuserinfo WHERE username = ?");
    mysqli_stmt_bind_param($prepStmt,"s",$userName);
    mysqli_stmt_execute($prepStmt);
    $sqldata = mysqli_stmt_get_result($prepStmt);
    $dataCheck = mysqli_fetch_assoc($sqldata);
    
    //checks to see if users login details are correct
    if(isset($dataCheck)){
        //nested if statment to remove salt and verify if the password is right
        if(password_verify($password,$dataCheck["password"])){
            //Session starts to create new session variables
            session_start();
            //Setting session variables
            $_SESSION["userName"] = $userName;
            $_SESSION["liveSession"] = True;
            $_SESSION["permissionLevel"] = $dataCheck["prolevel"];
            header("Location: mainDash.php");
        }
        else{
            header("Location: loginError.php");
        }
    }
    //Sends user to error page if details are wrong
    else{
        header("Location: loginError.php");
    }
?>
