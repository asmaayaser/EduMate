<?php
ob_start(); 
session_start();

    if (isset($_SESSION['id'])) {
        require '../connect.php';
        $use = $con->prepare('select apply from heads where id = ? ');
        $use->execute(array($_SESSION['id']));
        $coun = $use->fetch();
        if($coun[0]){

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bondi</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/Style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>

<body>
    <!-- navbar -->
<?php 
require 'header.php';
?>
    <!-- Dashboard -->
    <section class="Dashboard fw-bold text-center">
        <div class="users_info pt-4 bg-dark">
            <div class="search">
                <form action=" " method="get">
                    <input class="input_search me-2" type="search" placeholder="Search with name" name="search" aria-label="Search">
                    <button type="submit" class="search_icon"  style="background-color:transparent;border:0"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <?php
                    $usek = $con->prepare('select name from heads where id = ? ');
                    $usek->execute(array($_SESSION['id']));
                    $counk = $usek->fetch();
                ?>
                <div style=' color:white'>welcome back <?= $counk[0]?></div>
            </div>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>
                            <div class="container">
                                <div class="row methods mt-3 mb-4 rounded">
                                    <a class="col nav-link active p-2" href="./DashBoard.php" >users</a>
                                    <a class="col nav-link p-2" href="./task.php" >tasks</a>
                                    <a class="col nav-link p-2" href="./solutions.php" >task solutions</a>
                                    <a class="col nav-link p-2" href="./new.php" >news</a>
                                    <a class="col nav-link p-2" href="./unactive.php" >unactive users</a>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // delete
        if(isset($_POST['deletecommitte'])){
            $id = $_POST['id'];
            $selec = $con->prepare(' select photo from users where user_id  = ? ');
            $selec->execute(array($id));
            $committ = $selec->fetch();
            $p = 'uploads/';
            unlink($p.$committ[0]);
            $select2 = $con->prepare("delete from users where user_id  = ? ");
            $select2->execute(array($id));
            if($select2){
                echo '<div class="alert alert-success alert-dismissible fade show" style=" width: 90%;" role="alert">
                <strong>the user was deleted</strong>  
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
    }
?>
                    </tr>
                </tbody>
            </table>
        </div>
        <table class="table table-dark table-striped mt-1">
            <thead>
                <tr class="Header_elements">
                    <th scope="col">ID</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">phone</th>
                    <th scope="col"></th>
                    
                </tr>
            </thead>
            <tbody>
            <?php
                $selectx = $con->prepare(' select committe_id from heads where id = ? ');
                $selectx->execute(array($_SESSION['id']));
                $admins = $selectx->fetch();
            ?>
                <?php
                $selectc = $con->prepare(' select * from users where committe_id = ? AND apply = 1 ');
                $selectc->execute(array($admins[0]));
                $admins = $selectc->fetchAll();
                foreach($admins as $ab){
            ?>
                <tr>
                    <th scope="row"><?=$ab['user_id']?></th>
                    <td><?php
                        if($ab['photo']){
                            echo '<a href="../members/uploads/'.$ab['photo'].'" target="_blank"><img src="../members/uploads/'.$ab['photo'].'" width="50" height="50"></a><br>';
                        }
                        ?></td>
                    <td><?=$ab['name']?></td>
                    <td><?=$ab['email']?></td>
                    <td><?=$ab['phone']?></td>
                    <td><button class="btn btn-danger"  onclick="deletecommitte(<?=$ab['user_id']?>)">delete</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>





<!-- Modaldelet -->
<div class="modal fade" id="deletecommitte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> delete</h5>
    <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form method="post" action="">
            <div class="modal-body">
                <div class="basic-form">
                    <div class="form-row">
                        <div class="form-group col-md-6" style=" width: 97%;">
                            <input type="hidden" name="id" id="codeDeleteHam" class="form-control" value="">
                            <p>delete?</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">no</button>
            <button type="submit" class="btn btn-primary" name="deletecommitte">yes</button>
            </div>
        </form>
</div>
</div>
</div>


<script>
    function deletecommitte(x) {
    codeDeleteHam.value=x;
    var myModal = new bootstrap.Modal(document.getElementById("deletecommitte"), {});
    myModal.show();
    }
    </script>
    <script src="../js/bootstrap.bundle.min.js"></script>
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