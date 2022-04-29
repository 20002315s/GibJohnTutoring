<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>GibJohn Tutoring</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top" onload="startclock()">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
                <div class="container px-5">
                    <a class="navbar-brand" href="#page-top">GibJohn Tutoring</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-home"></i>Home</a></li>
                            <li class="nav-item"><a class="nav-link"  href="verification.php">Sign Up</a></li>
                            <li class="nav-item"><a class="nav-link" href="logIn.php">Log In</a></li>
                            <?php
                                session_start();
                                if(!isset($_SESSION["liveSession"])){
                                    $_SESSION["liveSession"]=False;
                                }
                                if($_SESSION["liveSession"] == True){
                                    echo '<li class="nav-item"><a class="nav-link" href="chat.php">Chat</a></li>';
                                    echo '<li class="nav-item"><a class="nav-link" id="activeLink" href="mainDash.php">Dashbord</a></li>';
                                    echo '<li class="nav-item"><a class="nav-link" id="logOutBtn" href="logOut.php">Log Out</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                    <div id="txt"></div>
                    <script>
                        function startclock() {
                        const today = new Date();
                        let hours = today.getHours();
                        let minutes = today.getMinutes();
                        let seconds = today.getSeconds();
                        minutes = consistencyCheck(minutes);
                        seconds = consistencyCheck(seconds);
                        document.getElementById('txt').innerHTML =  hours + ":" + minutes + ":" + seconds;
                        setTimeout(startclock, 1000);
                        }
                        function consistencyCheck(x) {
                        if (x < 10) {x = "0" + x};  // add zero in front of numbers < 10
                        return x;
                        }
                    </script>
                </div>
            </nav>
            <header class="masthead text-center text-white">
                <div class="masthead-content">
                    <div class="container px-5"></div>
                </div>
                <div class="bg-circle-1 bg-circle"></div>
                <div class="bg-circle-2 bg-circle"></div>
                <div class="bg-circle-3 bg-circle"></div>
                <div class="bg-circle-4 bg-circle"></div>
            </header>
            <div id="taskSpacer"><div>
                
        <?php
            if($_SESSION["liveSession"] == True){
                echo '<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top navWidthChange" id="profileHolder">';
                echo '<div class="profileBox">';
                echo '<div class="profileImg"><img src="User_Icon.png"> </div>';
                echo '<div class="profileText"><b>'.$_SESSION["userName"].'</b></div>';
                echo '</div>';
                echo '</nav>';
            }

            //will only desplay task creation botton if the user is a teacher 
            if($_SESSION["liveSession"] == True & $_SESSION["permissionLevel"] == 1){
                echo '<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top navWidthChange" id="taskCreatHolder">';
                echo '<a href="taskCreation.php" class="linkCleaner">';
                echo '<div class="taskCreatBox">';
                echo '<p><b>Add a Task</b></p>';
                echo '</div>';
                echo '</a>';
                echo '</nav>';
            }
        ?>

            <div id="taskFlexSpacer">

        <?php
            if($_SESSION["liveSession"] == True){
                include_once("DBconnectionLink.php");

                //selects all tasks from the database 
                $sqlq="SELECT * FROM task ORDER BY taskID DESC";
                $sqldata = mysqli_query($conLink, $sqlq);
                $dataCheck = mysqli_fetch_assoc($sqldata);

                //loops through all task and desplays then to the user 
                while($dataCheck){
                    $taskID=$dataCheck["taskID"];

                    echo '<div class="taskHolder">';
                    echo '<div class="taskBox">';
                    echo '<div class="topTaskLine">';
                    echo '<div class="taskHeader">';
                    echo '<h4>';
                    echo $dataCheck["taskCreationHeader"];
                    echo '</h4>';
                    echo '</div>';

                    //form that will take the student to the work page 
                    echo '<form method="GET" action="work.php">';
                    // hidden task id so all infomation can be submitted to the database at the same time 
                    echo '<input type="hidden" name="taskID" value="';
                    echo $dataCheck["taskID"];
                    echo '">';
                    echo '<button class="subWorkbtn" type="submit">Submit Work</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '<div class="taskDescription">';
                    echo $dataCheck["taskCreationDescription"];
                    echo '</div>';  

                    //checks the users promition level
                    if($_SESSION["liveSession"] == True & $_SESSION["permissionLevel"] == 1){
                        //SQL query using prepared statements to prevent against SQL injection
                        $prepStmt=mysqli_prepare($conLink,"SELECT * FROM work WHERE FKtaskID = ?");
                        mysqli_stmt_bind_param($prepStmt,"s",$taskID);
                        mysqli_stmt_execute($prepStmt);
                        $workSqldata = mysqli_stmt_get_result($prepStmt);
                        $workDataCheck = mysqli_fetch_assoc($workSqldata);

                        //loop to run through and desplay all the work submitted to the task 
                        while($workDataCheck){
                            echo '<div class ="submittedWorkHolder">';
                            echo '<form action="workView.php" method="GET">';
                            echo '<input type="hidden" name="workID" value="';
                            echo $workDataCheck["workID"];
                            echo '">';
                            echo '<button type="submit" class="submittedWorkBox">';
                            echo 'View '.$workDataCheck["FKusername"]."'s Work";
                            echo '</button>';
                            echo '</form>';
                            echo '</div>';
                            //resets the work while loop with new data 
                            $workDataCheck = mysqli_fetch_assoc($workSqldata);
                        }
                    }
                    echo '</div>';
                    echo '</div>';

                    //resets task while loop with new data 
                    $dataCheck = mysqli_fetch_assoc($sqldata);
                }
            }
        ?>
        </div>
            <!-- Bootstrap core JS-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Core theme JS-->
            <script src="js/scripts.js"></script>
    </body>
</html>