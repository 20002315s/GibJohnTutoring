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
                                    echo '<li class="nav-item"><a class="nav-link" id="activeLink"  href="chat.php">Chat</a></li>';
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
        ?>
        <div id="chatBox">
            <div id="chatTopBar">
                <form action="chatFunk.php" method="POST">
                    <input type="text" id="chatTextBox" placeholder="Enter Message Here" name="chat" required>
                    <button type="submit" id="chatSubmitBtn"><b>Send Message</b></button>
                </form>
            </div>
            <?php
                //will only desply chat if a user is logged in 
                if($_SESSION["liveSession"] == True){

                    include_once("DBconnectionLink.php");
                    $sqlq="SELECT * FROM chat ORDER BY chatID DESC";
                    $sqldata = mysqli_query($conLink, $sqlq);
                    $dataCheck = mysqli_fetch_assoc($sqldata);

                    //while loop to loop through all of the chats in the database and output them for the user to see
                    while($dataCheck){
                        echo '<div class="chatMessageBox">';
                        echo '<div class="chatUserName">';
                        echo $dataCheck["FKusername"];
                        echo '</div>';
                        echo '<div class="chatText">';
                        echo '<h6>';
                        echo $dataCheck["chat"];
                        echo '</h6>';
                        echo '</div>';
                        echo '</div>';

                        //resets the loop with new data 
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
