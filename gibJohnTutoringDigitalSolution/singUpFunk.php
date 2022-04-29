<?php
    //Link to database connection 
    include_once("DBconnectionLink.php");

    //Uses data from form
    $userName=$_POST["userName"];
    $email=$_POST["email"];
    $firstName=$_POST["firstName"];
    $lastName=$_POST["lastName"];
    $dateOfBirth=$_POST["dateOfBirth"];
    $password=$_POST["password"];
    $permissionLevel=$_POST["permissionLevel"];

    //password requirements
    $uppercaseCheck = preg_match('@[A-Z]@', $password);
    $lowercaseCheck = preg_match('@[a-z]@', $password);
    if(!$uppercaseCheck or !$lowercaseCheck){
        header("Location: passwordSingUpErrorPage.php");
    }
    else{
        if(strlen($password)>=8 ){
            if(strpos($password, "$") == True or strpos($password, "#") == True or strpos($password, "!") == True or strpos($password, "@") == True or strpos($password, "%") == True or strpos($password, "^") == True or strpos($password, "&") == True or strpos($password, "*") == True or strpos($password, "(") == True or strpos($password, ")") == True){
                if(strpos($password, "1") == True or strpos($password, "2") == True or strpos($password, "3") == True or strpos($password, "4") == True or strpos($password, "5") == True or strpos($password, "6") == True or strpos($password, "7") == True or strpos($password, "8") == True or strpos($password, "9") == True or strpos($password, "0") == True){
                    //Checks to see if username or email already exists
                    //prepared statements to prevent against SQL injection
                    $prepStmt=mysqli_prepare($conLink,"SELECT * FROM newuserinfo WHERE username = ? OR email = ?");
                    mysqli_stmt_bind_param($prepStmt,"ss",$userName,$email);
                    mysqli_stmt_execute($prepStmt);
                    $sqldata = mysqli_stmt_get_result($prepStmt);
                    $dataCheck = mysqli_fetch_assoc($sqldata);
                    
                    //If username or email is not in use user information gets uploaded to database
                    if(!isset($dataCheck)){
                        //hashes users password to ensure security
                        $hashedPassword=password_hash($password,PASSWORD_DEFAULT);
                        //prepared statements for inserting data to prevent against SQL injection
                        $prepStmt=mysqli_prepare($conLink,"INSERT INTO newuserinfo VALUES(?,?,?,?,?,?,?)");
                        mysqli_stmt_bind_param($prepStmt,"sssssss",$userName,$email,$firstName,$lastName,$dateOfBirth,$hashedPassword,$permissionLevel);
                        mysqli_stmt_execute($prepStmt);
                        header("Location: login.php");
                    }
                    //Sends user to error page if username or email is in use
                    else{
                        header("Location: singUpError.php");
                        }
                }
                //Sends user to error page if password dose not meet requirements
                else{
                    header("Location: passwordSingUpErrorPage.php");
                    }
            }
            else{
                header("Location: passwordSingUpErrorPage.php");
                }
        }
        else{
            header("Location: passwordSingUpErrorPage.php");
            }
    }
?>