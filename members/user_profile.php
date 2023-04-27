<?php
ob_start();
session_start();
if (isset($_SESSION['user_id'])) {
    require '../connect.php';
    $use = $con->prepare('select apply from users where user_id = ? ');
    $use->execute(array($_SESSION['user_id']));
    $coun = $use->fetch();
    if ($coun[0]) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>EduMate</title>
            <link rel="stylesheet" href="../css/normalize.css">
            <link rel="stylesheet" href="../css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/all.min.css">
            <link rel="stylesheet" href="../css/Style.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,700;1,400&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
        </head>

        <body>
            <?php
            require 'header.php';
            ?>
            <!-- profile -->
            <section class="profile pt-5 pb-3 text-center mb-5 pb-5 mt-5">
                <div class="container">
                    <?php
                    $selectx = $con->prepare(' select * from users where user_id = ? ');
                    $selectx->execute(array($_SESSION['user_id']));
                    $admins = $selectx->fetchall();
                    foreach ($admins as $ab) {
                    ?>
                        <div class="user_info row gap-lg-4">
                            <div class="card mb-sm-3 col-sm-12 col-md-3" style="min-width: 17rem;">
                                <?php
                                if ($ab['photo']) {
                                    echo '<a class="m-5 p-3" href="uploads/' . $ab['photo'] . '" target="_blank"><img class="card-img-top rounded-circle" alt="img" src="uploads/' . $ab['photo'] . '" ></a><br>';
                                }
                                ?>
                                <div class="card-body">
                                    <h5 class="card-title mb-4 fw-bold"><?= $ab['name'] ?></h5>
                                    <?php
                                    $selectc = $con->prepare(' select name from committes where id = ? ');
                                    $selectc->execute(array($ab['committe_id']));
                                    $admin = $selectc->fetch();
                                    ?>
                                    <ul class="info list-group list-group-flush rounded">
                                        <li class="list-group-item">
                                            <p class="card-text text-start"><span class="fw-bold">Commitee:</span> <?= " " . $admin[0] ?> </p>
                                            <p class="card-text text-start"><span class="fw-bold">Email:</span> <?= " " . $ab['email'] ?> </p>
                                            <p class="card-text text-start"><span class="fw-bold">Phone:</span> <?= " " . $ab['phone'] ?> </p>
                                        </li>
                                    </ul>
                                </div>
                            <?php } ?>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <button class="btns task_btn btn btn-primary active">Tasks</button>
                                </li>
                                <li class="list-group-item">
                                    <button class="btns post_btn btn btn-primary">Posts</button>
                                </li>
                            </ul>
                            </div>
                            <div class="content col-sm-12 col-md-8 border rounded p-3 active">
                                <h2 class="text-black-50 text-bold">Your Tasks</h2>
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    if (isset($_POST['deletecommitte'])) {
                                        $id = $_POST['id'];
                                        $imgNam  = $_FILES['imag']['name'];
                                        $imgSiz  = $_FILES['imag']['size'];
                                        $imgTm      = $_FILES['imag']['tmp_name'];
                                        $imgTyp  = $_FILES['imag']['type'];
                                        $description  = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                                        // List Of Allowed File Typed To Upload
                                        $imgAllowedExtensio = array("mp4", "pdf", "DoCX", "jpeg", "jpg", "png", "gif");
                                        // Get Avatar Extension
                                        $imgsx = explode('.', $imgNam);
                                        $imgExtensio = strtolower(end($imgsx));
                                        if (!empty($imgNam) && !in_array($imgExtensio, $imgAllowedExtensio)) {
                                            $formErrors[] = 'the extensions is not available';
                                        }
                                        $imgx = rand(0, 100000) . '_' . $imgNam;
                                        $uploads_dirx = 'uploads';
                                        move_uploaded_file($imgTm, "$uploads_dirx/$imgx");
                                        if (empty($formErrors)) {
                                            // Insert Userinfo In Database
                                            $insert = $con->prepare("INSERT INTO 
                                                    deliverables( link, comment, user_id, task_id)
                                                    VALUES( :zname, :zdesc, :zimg, :zhead)");
                                            $insert->execute(array(
                                                'zname'     => $imgx,
                                                'zdesc'     => $description,
                                                'zimg'      => $_SESSION['user_id'],
                                                'zhead'     => $id
                                            ));
                                            if ($insert) {
                                                echo '<div class="alert alert-success alert-dismissible fade show" style=" width: 90%;" role="alert">
                                            <strong>the solution was added</strong>  
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>';
                                            }
                                        } else {
                                            foreach ($formErrors as $error) {
                                                echo '
                                        <div class="alert alert-danger alert-dismissible fade show" style=" width: 90%;" role="alert">
                                        <strong>' . $error . '</strong> 
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>';
                                            }
                                        }
                                    }
                                }
                                ?>
                                <div class="row tasks w-100 pt-4">
                                    <?php
                                    $selectxl = $con->prepare(' select committe_id from users where user_id = ? ');
                                    $selectxl->execute(array($_SESSION['user_id']));
                                    $adminsl = $selectxl->fetch();
                                    $usek = $con->prepare('select id from heads where committe_id = ? ');
                                    $usek->execute(array($adminsl['committe_id']));
                                    $counk = $usek->fetch();
                                    $usekt = $con->prepare('select * from tasks where head_id = ? ');
                                    $usekt->execute(array($counk[0]));
                                    $counkt = $usekt->fetchall();
                                    foreach ($counkt as $asd) {
                                    ?>
                                        <div class="col-sm-6">
                                            <div class="card mb-2 shadow-lg">
                                                <div class="card-body">
                                                    <h5 class="card-title fw-bold mb-3"><?= $asd['title'] ?></h5>
                                                    <p class="card-text"><?= $asd['description'] ?></p>
                                                    <div class="mb-3 d-flex justify-content-center">
                                                        <?php
                                                        if ($asd['path']) {
                                                            echo '<a class="btn btn-primary p-0" href="../heads/uploads/' . $asd['path'] . '" target="_blank"><div color="black"><button class="btn btn-primary" >Open</button></div></a><br>';
                                                        }
                                                        ?>
                                                        <button class="btn btn-primary ms-2" onclick="deletecommitte(<?= $asd['id'] ?>)">Upload</button>
                                                    </div>
                                                    <p class="card-text text-start text-black-50">Created at <br><?= $asd['created'] ?></p>
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="content col-sm-12 col-md-8 border rounded p-3">
                                <h2 class="text-black-50 text-bold">Posts</h2>
                                <div class="row tasks w-100 pt-4">
                                    <?php
                                    $usektp = $con->prepare('select * from news where head_id = ? ');
                                    $usektp->execute(array($counk[0]));
                                    $counktp = $usektp->fetchall();
                                    foreach ($counktp as $asdp) {
                                    ?>
                                        <div class="col-sm-6">

                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $asdp['name'] ?></h5>
                                                    <p class="card-text"><?= $asdp['discription'] ?></p>
                                                    <p class="card-text">at: <?= $asdp['created'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                </div>
            </section>

            <!-- add model -->
            <div class="modal fade" id="deletecommitte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> New solution</h5>
                            <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="basic-form">
                                    <div class="form-row">
                                        <div class="form-group col-md-6" style=" width: 97%;">
                                            <input type="hidden" name="id" id="codeDeleteHam" class="form-control" value="">
                                            <div class="form-group col-md-6" style=" width: 97%;">
                                                <label>file</label>
                                                <input name="imag" type="file" id="formFile" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">description:</label>
                                                <textarea class="form-control" id="recipient-description" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">no</button>
                                <button type="submit" class="btn btn-primary" name="deletecommitte">yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--footer-->
            <?php require "footer.php"; ?>
            <script>
                function deletecommitte(x) {
                    codeDeleteHam.value = x;
                    var myModal = new bootstrap.Modal(document.getElementById("deletecommitte"), {});
                    myModal.show();
                }
            </script>
            <script src="../js/bootstrap.bundle.min.js"></script>
            <!-- <script src="./js/all.min.js"></script> -->
            <script src="../js/project.js"></script>
        </body>

        </html>
<?php
    }
} else {
    header('Location: ../404.php');
    exit();
}
ob_end_flush();
?>