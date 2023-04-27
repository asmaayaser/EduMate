<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
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
    <!-- Achievements -->
    <section class="achievements pt-5 pb-5 text-light fw-bold text-center text-lg-start">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 col-md-12">
                    <img class="img-fluid mb-4" src="./Images/work-steps.png" alt="school_img">
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="info w-md-100">
                                <h1 class="fw-bold mb-4 text-black">About IEEE</h1>
                                <p class="text-black-50 mb-5">
                                    IEEE: (institute of Electrical and Electronics Engineers)
                                    describes itself as "the world's largest technical professional
                                    society" promoting the development and the application of
                                    electro technology and allied sciences for the benefit of
                                    humanity , and the well- being of our members.
                                    IEEE is founded: (1 January 1963)
                                    IEEE kafrelshiekh student Branch is founded:
                                    (5 December 2013)
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="cards d-flex justify-content-center flex-wrap">
                                <div class="card p-5 m-2 text-center lh-lg">
                                    <i class="fa-solid fa-video d-block mb-3 fs-2 video"></i>
                                    <span class="d-block">450+</span>
                                    <span class="d-block">committe</span>
                                </div>
                                <div class="card p-5 m-2 text-center lh-lg">
                                    <i class="fa-solid fa-user-group d-block mb-3 fs-2 user"></i>
                                    <span class="d-block">79,000+</span>
                                    <span class="d-block">Students</span>
                                </div>
                                <div class="card p-5 m-2 text-center lh-lg">
                                    <i class="fa-solid fa-award d-block mb-3 fs-2 award"></i>
                                    <span class="d-block">26</span>
                                    <span class="d-block">Awards</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Our team -->
    <section class="team pt-5 pb-5 mt-5 fw-bold text-center">
        <div class="container">
            <h1 class="mb-5">Meet Our Team</h1>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card p-4 text-light">
                        <img class="rounded" src="./Images/Ahmed.jpeg" alt="team image">
                        <div class="card-body">
                            <h2 class="card-title">Ahmed Reda</h2>
                            <p class="card-text text-white-50">Frontend developer</p>
                        </div>
                        <div class="social">
                            <a href="https://www.linkedin.com/in/ahmed-reda-768b34231/"><i class="fa-brands fa-linkedin fa-xl linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card p-4 text-light">
                        <img class="rounded" src="./Images/asmaa2.jpg" alt="team image">
                        <div class="card-body">
                            <h2 class="card-title">Asmaa Yasser</h2>
                            <p class="card-text text-white-50">Full-stack developer</p>
                        </div>
                        <div class="social">
                            <a href=" https://www.linkedin.com/in/asmaayaser358/"><i class="fa-brands fa-linkedin fa-xl linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card p-4 text-light">
                        <img class="rounded" src="./Images/Alaa2.jpg" alt="team image">
                        <div class="card-body">
                            <h2 class="card-title">Alaa Ali</h2>
                            <p class="card-text text-white-50">Backend developer</p>
                        </div>
                        <div class="social">
                            <a href="https://www.linkedin.com/in/alaa-el-shehawy-690922251"><i class="fa-brands fa-linkedin fa-xl linkedin"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
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