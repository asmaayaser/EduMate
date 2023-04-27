<?php
ob_start(); 
session_start();
require 'connect.php';
if (isset($_SESSION['admin_id'])) {
    header('Location: admin/DashBoard.php');
}
if (isset($_SESSION['id'])) {$use = $con->prepare('select apply from heads where id = ? ');
    $use->execute(array($_SESSION['id']));
    $coun = $use->fetch();
    if($coun[0]){
        header('Location: heads/DashBoard.php');
    }else{
        header('Location: wait.php');
    }
    
}
if (isset($_SESSION['user_id'])) {$use = $con->prepare('select apply from users where user_id  = ? ');
    $use->execute(array($_SESSION['user_id']));
    $coun = $use->fetch();
    if($coun[0]){
        header('Location: members/user_profile.php');
    }else{
        header('Location: wait.php');
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/Style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,700;1,400&display=swap"
        rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <div class="login_page d-flex align-items-center justify-content-center">
        <div class="container">
        <form method="post" action="" enctype="multipart/form-data">
                <h2>Login</h2>
                <?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $choice   = $_POST['flexRadioDefault'];
        $email    = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        if (empty($email)) {
            $formErrors[] = 'please enter your email';
        }
        if (isset($password)) {
            if (strlen($password) < 6) {$formErrors[] = 'password must be greater than 6 characters or numbers';}
        }else{
            $formErrors[] = 'please entre the password';
        }
        if (empty($formErrors)) {
            if($choice == 'admin'){
            $user = $con->prepare('select * from admin where email = ? and password = ?');
            $user->execute(array($email,sha1($password)));
            $count = $user->rowCount();
            if ($count > 0) {
                $data = $user->fetch();
                $_SESSION['admin_id'] = $data['admin_id']; 
                header('Location: admin/DashBoard.php'); 
                exit();
            } else {
                echo '
                    <div class="alert alert-danger text-center alert-dismissible fade show text-light" role="alert">
                    this admin not valid
                    </div>
                ';
            }
        }elseif($choice == 'head'){
            $user = $con->prepare('select * from heads where email = ? and password = ? ');
            $user->execute(array($email,sha1($password)));
            $count = $user->rowCount();
            if ($count > 0) {
                $data = $user->fetch();
                $_SESSION['id'] = $data['id']; 
                if($data['apply']){
                    header('Location: heads/DashBoard.php');
                }else{
                    header('Location: wait.php');
                }
                exit();
            } else {
                echo '
                    <div class="alert alert-danger text-center alert-dismissible fade show text-light" role="alert">
                    this head not valid
                    </div>
                ';
            }
        }elseif($choice == 'membr'){
            $user = $con->prepare('select * from users where email = ? and password = ? ');
            $user->execute(array($email,sha1($password)));
            $count = $user->rowCount();
            if ($count > 0) {
                $data = $user->fetch();
                $_SESSION['user_id'] = $data['user_id']; 
                if($data['apply']){
                    header('Location: members/user_profile.php');
                }else{
                    header('Location: wait.php');
                }
                exit();
            } else {
                echo '
                    <div class="alert alert-danger text-center alert-dismissible fade show text-light" role="alert">
                    this member not valid
                    </div>
                ';
            }
        }

        } else {
            foreach ($formErrors as $error) {
                echo '
                    <div class="alert alert-danger text-center alert-dismissible fade show text-light" role="alert">
                    ' . $error . '
                    </div>
                ';
            }
        }
    }
}
?>
                <div class="form-group">
                    <label for="email">email:</label>
                    <input type="text" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="Position rounded p-2 d-flex justify-content-around align-items-center mt-3 mb-4">
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" value="admin" id="flexRadioDefault1">
                        <label class="form-check-label mb-0 ms-1 mt-1" for="flexRadioDefault1">Admin</label>
                    </div>
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" value="head" id="flexRadioDefault2" checked>
                        <label class="form-check-label mb-0 ms-1 mt-1" for="flexRadioDefault2">Head</label>
                    </div>
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" value="membr" id="flexRadioDefault3">
                        <label class="form-check-label mb-0 ms-1 mt-1" for="flexRadioDefault3">Member</label>
                    </div>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
                <div class="form-group">
                <p class="text-center">Don't have an account? <a href="./Register.php">Sign up</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>