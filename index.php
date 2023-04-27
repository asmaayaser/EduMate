<?php
require 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduMate</title>
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
    <!-- Landing -->
    <section class="landing pt-5 pb-5 text-light fw-bold text-center text-lg-start">
        <div class="container">
            <div class="info-section align-items-center lh-lg">
                <div class="info w-md-100 text-center">
                    <h1 class="fw-bold mb-4 lh-base">
                        <span class="green">Learn</span> on your class <span class="yellow">schedule</span>
                    </h1>
                    <p class="text-white-50">
                        The Kafr El Sheikh University community was founded in 2014, aiming to promote advanced
                        technology through education, practice,
                        and innovation for both university students and graduates.
                    </p>
                </div>
                <div class="d-flex justify-content-center">
                    <?php
                    if (isset($_SESSION['id']) || isset($_SESSION['admin_id']) || isset($_SESSION['user_id'])) {
                        echo '<a href="./index.php" class="btn-join btn ps-4 pe-4 pt-2 pb-2 mt-5 fw-bold fs-5">Join Us</a>';
                    } else {
                        echo '<a href="login.php" class="btn-join btn ps-4 pe-4 pt-2 pb-2 mt-5 fw-bold fs-5">Join Us</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- our Committees -->
    <section class="committe pt-5 pb-5 text-center">
        <div class="container">
            <h2 class="mt-5 mb-5 fw-bold">Our committees</h2>
            <div class="row">
                <?php
                $select = $con->prepare(' select * from committes ');
                $select->execute();
                $committes = $select->fetchAll();
                foreach ($committes as $committe) {
                ?>
                    <div class="col-md-6 col-lg-4 mt-4">
                        <div class="card shadow">
                            <?php
                            if ($committe['photo']) {
                                echo '<a href="admin/uploads/' . $committe['photo'] . '" target="_blank"><img class="img card-img-top" alt="course image" src="admin/uploads/' . $committe['photo'] . '" width="374.4" height="209.66"></a><br>';
                            }
                            ?>
                            <?php
                            $usek = $con->prepare('select name from heads where committe_id  = ? AND apply = 1 ');
                            $usek->execute(array($committe['id']));
                            $counk = $usek->fetch();
                            if (isset($counk[0])) {
                                echo '<span class="fw-bold fs-5">'  . $counk[0] . '</span>';
                            } else {
                                echo '<span class="fw-bold fs-5">Un Known</span>';
                            }
                            ?>
                            <div class="card-body">
                                <p class="card-text"><?= $committe['description'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- questions -->
    <section class="questions pt-5 pb-5">
        <div class="container">
            <h2 class="text-center fw-bold mt-5 mb-5">Frequently Asked Questions</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="question-container p-4 rounded shadow">
                        <div class="question d-flex align-items-center">
                            <i class="fa-solid fa-plus fs-4 me-3 icon"></i>
                            <!-- <i class="fa-solid fa-minus fs-4 me-3"></i> -->
                            <h3 class="fw-bold">Who is the IEEE organization ?</h3>
                        </div>
                        <p class="text-white-50 lh-base fw-bold mt-4">
                            IEEE: (institute of Electrical and Electronics Engineers)
                            describes itself as "the world's largest technical professional
                            society" promoting the development and the application of
                            electro technology and allied sciences for the benefit of
                            humanity , and the well- being of our members.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="question-container p-4 rounded shadow">
                        <div class="question d-flex align-items-center">
                            <i class="fa-solid fa-plus fs-4 me-3 icon"></i>
                            <!-- <i class="fa-solid fa-minus"></i> -->
                            <h3 class="fw-bold">When was IEEE founded ?</h3>
                        </div>
                        <p class="text-white-50 lh-base fw-bold mt-4">
                            IEEE is founded: (1 January 1963)
                            IEEE kafrelshiekh student Branch is founded:
                            (5 December 2013)
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="question-container p-4 rounded shadow">
                        <div class="question d-flex align-items-center">
                            <i class="fa-solid fa-plus fs-4 me-3 icon"></i>
                            <!-- <i class="fa-solid fa-minus"></i> -->
                            <h3 class="fw-bold">What is the Vision of this organization ?</h3>
                        </div>
                        <p class="text-white-50 lh-base fw-bold mt-4">
                            IEEE will be essential to the global technical community
                            and to technical professionals everywhere, and be universally
                            recognized for the contributions of technology and technical
                            professionals in improving global conditions.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="question-container p-4 rounded shadow">
                        <div class="question d-flex align-items-center">
                            <i class="fa-solid fa-plus fs-4 me-3 icon"></i>
                            <!-- <i class="fa-solid fa-minus"></i> -->
                            <h3 class="fw-bold">What are the missions of this organization?</h3>
                        </div>
                        <p class="text-white-50 lh-base fw-bold mt-4">
                            IEEE's core purpose is to foster technological
                            innovation and excellence for the benefit to humanity.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="question-container p-4 rounded shadow">
                        <div class="question d-flex align-items-center">
                            <i class="fa-solid fa-plus fs-4 me-3 icon"></i>
                            <!-- <i class="fa-solid fa-minus"></i> -->
                            <h3 class="fw-bold">What is the main goals of this organization?</h3>
                        </div>
                        <p class="text-white-50 lh-base fw-bold mt-4">
                            nurtures, develops, and advances the building of
                            global technologies.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- testimonials -->
    <section class="testimonials pt-5 pb-5 text-center">
        <div class="container">
            <h2 class="fw-bold mt-5 mb-5">Officials</h2>
            <div class="row">
                <?php
                $selectc = $con->prepare(' select * from admin where admin_id != 1 ');
                $selectc->execute();
                $admins = $selectc->fetchAll();
                foreach ($admins as $ab) {
                ?>
                    <div class="col-md-6">
                        <?php
                        if ($ab['photo']) {
                            echo '<a href="admin/uploads/' . $ab['photo'] . '" target="_blank"><img class="mb-4 rounded-circle" src="admin/uploads/' . $ab['photo'] . '"></a><br>';
                        } ?>
                        <h3 class="fw-bold"><?= $ab['name'] ?></h3>
                        <h4 class="fw-bold text-warning mb-5"><?= $ab['head_job'] ?></h4>
                        <div class="position-relative">
                            <p class="fs-5 p-4 text-white-50 rounded text-start lh-lg"><?= $ab['discription'] ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- footer -->
    <?php require 'footer.php' ?>


    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/project.js"></script>
</body>

</html>
<?
ob_end_flush();
?>