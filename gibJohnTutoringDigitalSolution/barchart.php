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
        <!-- JavaScript barchat-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    </head>
    <body id="page-top" onload="startclock()">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
            <div class="container px-5">
                <a class="navbar-brand" href="#page-top">GibJohn Tutoring</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link"  href="index.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="verification.php">Sign Up</a></li>
                        <li class="nav-item"><a class="nav-link"  href="logIn.php">Log In</a></li>
                        <?php
                            session_start();
                            if(!isset($_SESSION["liveSession"])){
                                $_SESSION["liveSession"]=False;
                            }
                            if($_SESSION["liveSession"] == True){
                                echo '<li class="nav-item"><a class="nav-link" href="chat.php">Chat</a></li>';
                                echo '<li class="nav-item"><a class="nav-link" href="mainDash.php">Dashbord</a></li>';
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
        <?php
        if($_SESSION["liveSession"] == True){
            echo '<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top" id="profileHolder">';
            echo '<div class="profileBox">';
            echo '<div class="profileImg"><img src="User_Icon.png"> </div>';
            echo '<div class="profileText"><b>'.$_SESSION["userName"].'</b></div>';
            echo '</div>';
            echo '</nav>';
        }
        ?>
        <!-- Header-->
        <header class="masthead text-center text-white">
            <div class="masthead-content">
                <div class="container px-5">
                    <h2 class="masthead-heading mb-0">Students points</h2>  
                    </div>
                </div>
            </div>
            <div class="bg-circle-1 bg-circle"></div>
            <div class="bg-circle-2 bg-circle"></div>
            <div class="bg-circle-3 bg-circle"></div>
            <div class="bg-circle-4 bg-circle"></div>
        </header>
        <div id="barChart">
        <canvas id="myChart" style="width:100%;max-width:2000px"></canvas>
        </div>
        <!-- JavaScript for a bar chart-->
        <script>
            <?php
                //connection to database
                include_once("DBconnectionLink.php");
                //Users data
                $mark = $_GET["mark"];
                $workID = $_GET["workID"];

                //Updates existing mark with new mark
                $UPDATEprepStmt=mysqli_prepare($conLink,"UPDATE work SET mark = ? WHERE workID = ?;");
                mysqli_stmt_bind_param($UPDATEprepStmt,"si",$mark,$workID);
                mysqli_stmt_execute($UPDATEprepStmt);
            ?>

            var xValues=[
                            <?php
                            //creates bar for each user on the database
                                $sqlq="SELECT * FROM newuserinfo";
                                $sqldata = mysqli_query($conLink, $sqlq);
                                $dataCheck = mysqli_fetch_assoc($sqldata);
                                $totMark = 0;
                                while($dataCheck){
                                    $userName = $dataCheck["username"];
                                    echo "'";
                                    echo $userName;
                                    echo "'";
                                    echo ",";
                                    //re-runs loop with new data
                                    $dataCheck = mysqli_fetch_assoc($sqldata);
                                }
                            ?>
                        ];

            var yValues=[
                            <?php
                            //assigns a mark to each bar on the bar chart                   
                                $sqlq="SELECT * FROM newuserinfo";
                                $sqldata = mysqli_query($conLink, $sqlq);
                                $dataCheck = mysqli_fetch_assoc($sqldata);
                                //sets the total mark to zero
                                $totMark = 0;
                                //while loop to run through and count every mark assigned to a users piece of work 
                                while($dataCheck){
                                    $userName = $dataCheck["username"];
                                    $markprepStmt=mysqli_prepare($conLink,"SELECT * FROM work WHERE FKusername = ?");
                                    mysqli_stmt_bind_param($markprepStmt,"s",$userName);
                                    mysqli_stmt_execute($markprepStmt);
                                    $markSqldata = mysqli_stmt_get_result($markprepStmt);
                                    $markDataCheck = mysqli_fetch_assoc($markSqldata);
                                    while($markDataCheck){
                                        $totMark += $markDataCheck["mark"];
                                        $markDataCheck = mysqli_fetch_assoc($markSqldata);
                                    }
                                    echo"'";
                                    echo $totMark;
                                    echo"'";
                                    echo",";
                                    //resets total mark to zero
                                    $totMark =0;
                                    //re-runs loop with new data
                                    $dataCheck = mysqli_fetch_assoc($sqldata);
                                }
                            ?>
                        ];
            //assigns colour to bar
            var barColors = "blue"
            new Chart("myChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                backgroundColor: barColors,
                data: yValues
                }]
            },
            options: {
                legend: {display: false},
                title: {
                display: true,
                text: "Students overall points"
                }
            }
            });
        </script>
        <!-- Footer-->
        <footer class="py-5 bg-black">
            <!-- suport number-->
            <div class="container px-5"><p class="m-0 text-center text-white small">For any support please contact: +44 117 496 0702</p></div>
            <!-- copy right infomation-->
            <div class="container px-5"><p class="m-0 text-center text-white small">Copyright &copy; GibJohn Tutoring 2022</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>



