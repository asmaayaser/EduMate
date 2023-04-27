<?php
require 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bondi</title>
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/Style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>

<body>
    <?php
    ob_start();
    session_start();
    if (isset($_SESSION['id'])) {
        require 'headerh.php';
    } elseif (isset($_SESSION['admin_id'])) {
        require 'headera.php';
    } elseif (isset($_SESSION['user_id'])) {
        require 'headerm.php';
    } else {
        require 'header.php';
    }
    ?>
    <!-- contact -->
    <div class="contact pb-5 pt-5 text-center text-lg-start">
        <div class="container">
            <div class="row contact-content position-relative rounded pt-5 pb-5 mt-5 mb-5">
                <div class="col-lg-6">
                    <div class="contactUs rounded ps-4 pe-4 pt-3 pb-3 text-light">
                        <img src="./Images/login.png" alt="contactUs image">
                        <h2 class="fw-bold">Contact Us</h2>
                        <p class="text-white-50 mb-5">
                            Have a question? <br>
                            We’re happy to help! Fill out the form below and we’ll get back to you as soon as possible.
                        </p>
                        <ul class="contact-info list-unstyled mb-5 lh-lg">
                            <li>
                                <a class="d-flex gap-3 align-items-center" href="#">
                                    <i class="fa-solid fa-phone-volume phone"></i>
                                    <span>+201009797821</span>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex gap-3 align-items-center" href="#">
                                    <i class="fa-solid fa-envelope mail"></i>
                                    <span>ahmed@gmail.com</span>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex gap-3 align-items-center" href="#">
                                    <i class="fa-solid fa-location-dot location"></i>
                                    <span>Egypt, kfs student bransh</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="contact-social list-unstyled d-flex gap-4">
                            <li>
                                <a href="#"><i class="fa-brands fa-facebook facebook fs-3"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-brands fa-instagram instagram fs-3"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-brands fa-twitter twitter fs-3"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-brands fa-linkedin linkedin fs-3"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['massage'])) {
                            $fname      = filter_var($_POST['FirstName'], FILTER_SANITIZE_STRING);
                            $lname      = filter_var($_POST['LastName'], FILTER_SANITIZE_STRING);
                            $email     = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
                            $massege   = filter_var($_POST['text'], FILTER_SANITIZE_STRING);
                            $insert = $con->prepare("INSERT INTO 
                            massages( first_name, last_name, email, massage) 
                            VALUES( :kfname, :klname, :kEmail, :kmassege)");
                            $insert->execute(array(
                                'kfname'    => $fname,
                                'klname'    => $lname,
                                'kEmail'   => $email,
                                'kmassege' => $massege
                            ));
                            if ($insert) {
                                echo '<div class="alert alert-success alert-dismissible fade show" style=" width: 90%;" role="alert">
                        <strong>your message has been received</strong>  
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                            }
                        }
                    }
                    ?>
                    <div class="form p-5">
                        <form action="" method="post">
                            <div class="inputs d-flex gap-lg-2 mb-4">
                                <input class="p-2 rounded" type="text" name="FirstName" placeholder="First Name" required>
                                <input class="p-2 rounded" type="text" name="LastName" placeholder="Last Name" required>
                            </div>
                            <input class="d-block w-100 mb-4 p-2 rounded" type="email" name="email" required placeholder="Your Email Address">
                            <textarea class="d-block w-100 mb-5 rounded p-2" name="text" placeholder="Write Your Message" required></textarea>
                            <button class="btn btn-primary" name="massage" type="submit">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <?php require 'footer.php' ?>


    <script src="./js/bootstrap.bundle.min.js"></script>
    <!-- <script src="./js/all.min.js"></script> -->
    <script src="./js/project.js"></script>
</body>

</html>
<?
ob_end_flush();
?>