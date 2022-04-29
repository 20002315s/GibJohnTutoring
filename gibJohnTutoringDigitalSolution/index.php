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

    <!-- Upon load of the page we start the JavaScript clock -->
    <body id="page-top" onload="startclock()">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
            <div class="container px-5">
                <a class="navbar-brand" href="#page-top">GibJohn Tutoring</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" id="activeLink" href="index.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="verification.php">Sign Up</a></li>
                        <li class="nav-item"><a class="nav-link" href="logIn.php">Log In</a></li>
                        <?php
                            //Starts a session for access to variables
                            session_start();
                            
                            //Checks to see if variable is defined and if not sets to false to avoid error
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

                <!--JavaScript for a clock which will be consistent throughout all pages on the website-->
                <script>
                    function startclock() {
                    const today = new Date();
                    //gets hours
                    let hours = today.getHours();
                    //gets minutes
                    let minutes = today.getMinutes();
                    //gets seconds 
                    let seconds = today.getSeconds();
                    minutes = consistencyCheck(minutes);
                    seconds = consistencyCheck(seconds);
                    document.getElementById('txt').innerHTML =  hours + ":" + minutes + ":" + seconds;
                    setTimeout(startclock, 1000);
                    }

                    //This function makes sure that the time is always displayed in the same format (4 numbers)
                    function consistencyCheck(x) {
                    if (x < 10) {x = "0" + x};  // add zero in front of numbers < 10
                    return x;
                    }
                </script>
            </div>
        </nav>
        <!-- Checks to see if the user has succsessfully logged into an account then displays username-->
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
                    <h1 class="masthead-heading mb-0">Welcome to</h1>
                    <h2 class="masthead-subheading mb-0">innovative learning</h2>
                    <div class="container px-5">
                        <a class="btn btn-primary btn-xl rounded-pill mt-5" href="logIn.php">Log in</a>
                        <a class="btn btn-primary btn-xl rounded-pill mt-5" href="verification.php">Sing up</a>
                        
                    </div>
                    <a class="btn btn-primary btn-xl rounded-pill mt-5" href="#scroll">Learn More</a>
                </div>
            </div>
            <div class="bg-circle-1 bg-circle"></div>
            <div class="bg-circle-2 bg-circle"></div>
            <div class="bg-circle-3 bg-circle"></div>
            <div class="bg-circle-4 bg-circle"></div>
        </header>
        <!-- Content section 1-->
        <section id="scroll">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6 order-lg-2">
                        <div class="p-5"><img class="img-fluid rounded-circle" src="happyClassroom.webp" alt="image of a happy classroom environment" /></div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="p-5">
                            <h2 class="display-4">For your learning needs</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content section 2-->
        <section>
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="p-5"><img class="img-fluid rounded-circle" src="digitalLearning.avif" alt="image of children learning on many devices" /></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <h2 class="display-4">On any device</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content section 3-->
        <section>
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6 order-lg-2">
                        <div class="p-5"><img class="img-fluid rounded-circle" src="universityLearning.jpg" alt="image of university students learning" /></div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="p-5">
                            <h2 class="display-4">For every level of education</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content section 4-->
        <section>
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="p-5"><img class="img-fluid rounded-circle" src="disabilityLearning.jpeg" alt="image of a disabled girl learning" /></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <h2 class="display-4">We are here for you!</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-black">
            <div class="container px-5"><p class="m-0 text-center text-white small">For any support please contact: +44 117 496 0702</p></div>
            <div class="container px-5"><p class="m-0 text-center text-white small">Copyright &copy; GibJohn Tutoring 2022</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
