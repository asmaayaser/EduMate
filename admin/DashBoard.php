<?php
ob_start(); 
session_start();
if (isset($_SESSION['admin_id'])) {
    require '../connect.php';
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
<?php 
require 'header.php';
?>
    <!-- Dashboard -->
    <section class="Dashboard fw-bold text-center">
        <div class="users_info pt-4 bg-dark">
            <div class="search">
                <form action=" " method="get">
                    <input class="input_search me-2" type="search" placeholder="Search with name or email" name="search" aria-label="Search">
                    <button type="submit" class="search_icon"  style="background-color:transparent;border:0"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <?php
                    $usek = $con->prepare('select name from admin where admin_id = ? ');
                    $usek->execute(array($_SESSION['admin_id']));
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
                                    <a class="col nav-link p-2 active" href="./DashBoard.php" >Admin</a>
                                    <a class="col nav-link p-2" href="./committee.php" >Committee</a>
                                    <a class="col nav-link p-2" href="./head.php" >Head</a>
                                    <a class="col nav-link p-2" href="./unactive.php" >Unactive head</a>
                                    <a class="col nav-link p-2" href="./massage.php" >Masseges</a>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td colspan="3"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Add New Admin</button></td>
                        <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['addcommitte'])) {
            $name = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            $email    = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $job      = filter_var($_POST['job'],FILTER_SANITIZE_STRING);
            $imgNam  = $_FILES['imag']['name'];
            $imgSiz  = $_FILES['imag']['size'];
            $imgTm	  = $_FILES['imag']['tmp_name'];
            $imgTyp  = $_FILES['imag']['type'];
            $description  = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            // List Of Allowed File Typed To Upload
            $imgAllowedExtensio = array("jpg", "png", "gif","jpeg");
            // Get Avatar Extension
            $imgsx = explode('.', $imgNam);
            $imgExtensio = strtolower(end($imgsx));
            if (! empty($imgNam) && ! in_array($imgExtensio, $imgAllowedExtensio)) {
                $formErrors[] = 'image extensions is not available';
            }
            $imgx = rand(0, 100000) . '_' . $imgNam;
            $uploads_dirx = 'uploads';
            move_uploaded_file($imgTm, "$uploads_dirx/$imgx");
            if(empty($name)){
                $formErrors[] = 'please enter the name';
            }
            if (empty($formErrors)) {
                    // Insert Userinfo In Database
                    $insert = $con->prepare("INSERT INTO 
                        admin(name, discription, email, password, head_job, photo)
                        VALUES(:zuser, :zdis, :zemail, :zpass, :zjob, :zimg)");
                    $insert->execute(array(
                        'zuser'     => $name,
                        'zdis'      => $description,
                        'zemail'    => $email,
                        'zpass'     => sha1($password),
                        'zjob'      => $job,
                        'zimg'      => $imgx
                    ));
                    if ($insert) {
                        echo '<div class="alert alert-success alert-dismissible fade show" style=" width: 90%;" role="alert">
                        <strong>the admin was added</strong>  
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
            } 
            else {
                foreach ($formErrors as $error) {
                    echo '
                    <div class="alert alert-danger alert-dismissible fade show" style=" width: 90%;" role="alert">
                    <strong>'.$error.'</strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }
        }
        // delete
        if(isset($_POST['deletecommitte'])){
            $id = $_POST['id'];
            $selec = $con->prepare(' select photo from admin where admin_id = ? ');
            $selec->execute(array($id));
            $committ = $selec->fetch();
            $p = 'uploads/';
            unlink($p.$committ[0]);
            $select2 = $con->prepare("delete from admin where admin_id = ? ");
            $select2->execute(array($id));
            if($select2){
                echo '<div class="alert alert-success alert-dismissible fade show" style=" width: 90%;" role="alert">
                <strong>the admin was deleted</strong>  
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
        //udate
        if(isset($_POST['editproduct'])){
            $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $job  = filter_var($_POST['job'],FILTER_SANITIZE_STRING);
            $description  = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            $id      = $_POST['id'];
                if(empty($name)){
                    $erro[] = 'please entre the name';
                }
                if(empty($job)){
                    $erro[] = 'please entre the job';
                }
                if(empty($description)){
                    $erro[] = 'please entre the about filed';
                }
            if(empty($erro)){
                $aa = $con->prepare("
                    update admin set
                    name = :znam,
                    discription = :zdes,
                    head_job = :zjob
                    where admin_id = :zid
                ");
                $aa->execute(array('znam' => $name, 'zjob' => $job, 'zdes' => $description, 'zid' => $id));
                if ($aa) {
                    echo '<div class="alert alert-success alert-dismissible fade show" style=" width: 90%;" role="alert">
                    <strong>the admin was updated</strong>  
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
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
                    <th scope="col">Job</th>
                    <th scope="col">About</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $select = $con->prepare(' select * from admin where admin_id = 1 ');
                $select->execute();
                $mainadmin = $select->fetchAll();
                foreach($mainadmin as $a){
            ?>
                <tr>
                    <th scope="row"><?=$a['admin_id']?></th>
                    <td><?php
                        if($a['photo']){
                            echo '<a href="uploads/'.$a['photo'].'" target="_blank"><img src="uploads/'.$a['photo'].'" width="50" height="50"></a><br>';
                        }
                        ?></td>
                    <td><?=$a['name']?></td>
                    <td><?=$a['email']?></td>
                    <td><?=$a['head_job']?></td>
                    <td><?=$a['discription']?></td>
                    <td>
                    </td>
                </tr>
                <?php } ?>
                <?php
                $selectc = $con->prepare(' select * from admin where admin_id != 1 ');
                $selectc->execute();
                $admins = $selectc->fetchAll();
                foreach($admins as $ab){
            ?>
                <tr>
                    <th scope="row"><?=$ab['admin_id']?></th>
                    <td><?php
                        if($ab['photo']){
                            echo '<img src="uploads/'.$ab['photo'].'" width="50" height="50"><br>';
                        }
                        ?></td>
                    <td><?=$ab['name']?></td>
                    <td><?=$ab['email']?></td>
                    <td><?=$ab['head_job']?></td>
                    <td><?=$ab['discription']?></td>
                    <td><button class="btn btn-danger"  onclick="deletecommitte(<?=$ab['admin_id']?>)">delete</button>
                    <button class="btn btn-secondary" onclick="editcommitte(`<?=$ab['name']?>` ,`<?=$ab['head_job']?>`,`<?=$ab['discription']?>`,`<?=$ab['admin_id']?>`)">update</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

    <!--add modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">New admin</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">name:</label>
            <input type="text" class="form-control" id="recipient-title" name="title" >
        </div><div class="mb-3">
            <label for="recipient-name" class="col-form-label">email:</label>
            <input type="text" class="form-control" id="email" name="email" >
        </div>
        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">password:</label>
            <input type="text" class="form-control" id="password" name="password" >
        </div><div class="mb-3">
        </div><div class="mb-3">
            <label for="recipient-name" class="col-form-label">job:</label>
            <input type="text" class="form-control" id="job" name="job" >
        </div>
        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">about:</label>
            <textarea class="form-control" id="recipient-description" name="description"></textarea>
        </div>
        <div class="form-group col-md-6" style=" width: 97%;">
            <label>photo</label>
            <input name="imag" type="file" id="formFile" class="form-control" >
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="addcommitte">add</button>
        </form>
    </div>
    </div>
</div>
</div>

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






    <!-- Modal edit-->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">edit</h5>
        <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form method="post" action="">
        <div class="modal-body">
            <div class="basic-form">
                <div class="form-row">
                <div class="form-group col-md-6" style=" width: 97%;">
                    <div class="form-group col-md-6" style=" width: 97%;">
                        <label>name</label>
                        <input type="text" name="name" id="nameedit" class="form-control" placeholder="name">
                    </div>
                    <div class="form-group col-md-6" style=" width: 97%;">
                        <label>job</label>
                        <input type="text" name="job" id="jobedit" class="form-control" placeholder="job">
                    </div>
                    <input type="hidden" name="id" id="codeeditHam" class="form-control" value="">
                    <div class="form-group col-md-6" style=" width: 97%;">
                        <label>about</label>
                        <textarea class="form-control" id="descriptionedit" name="description"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
        <button type="submit" class="btn btn-primary" name="editproduct">save</button>
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
    function editcommitte(name,job,description,id){
        nameedit.value = name;
        jobedit.value = job;
        descriptionedit.value = description;
        codeeditHam.value = id;
        var myModal = new bootstrap.Modal(document.getElementById("editModal"), {});
        myModal.show();
    }
    </script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <!-- <script src="./js/all.min.js"></script> -->
    <script src="../js/project.js"></script>
</body>

</html>
<?php
} else {
    header('Location: ../404.php');
    exit();
}
ob_end_flush(); 
?>